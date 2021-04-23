-- -----------------------------------------------------------------------------
--             G�n�ration d'une base de donn�es pour
--                      Oracle Version 10g XE
--                        
-- -----------------------------------------------------------------------------
--      Projet : MaisonDesLigues
--      Auteur : Beno�t ROCHE
--      Date de derni�re modification : 19/01/2013 11:32:40
-- -----------------------------------------------------------------------------
-- -----------------------------------------------------------------------------
--      Script de cr�ation des packages 
--				- des packages contenant les proc�dures et fonctions stock�es
-- 				- des triggers
--
--		Ce script doit �tre ex�cut� par un l'utilisateur MDL
--		(celui qui vient d'�tre cr�� dans le script creer_user)
--- -----------------------------------------------------------------------------
drop public synonym fonctionsdiverses;
drop public synonym PCKATELIER;
drop public synonym PCKPARTICIPANT;
-- -----------------------------------------------------------------------------
--       PACKAGE fonctionsdiverses
--------------------------------------------------------------------------------
--       PACKAGE fonctionsdiverses ENTETE
--
create or replace
package fonctionsdiverses
is
  function premierjour return  timestamp;
  function dernierjour return  timestamp;
  function dureevacation return integer;
  function recuperenbmaxatelier return integer;
  function newidatelier return integer;
end fonctionsdiverses;
/
--
--		  fin PACKAGE fonctionsdiverses ent�te
--
--       PACKAGE fonctionsdiverses BODY
--
create or replace
package body fonctionsdiverses
is
  /*
    cette fonction retourne le premier jour de la manifestation.
    On peut le r�cup�rer grace � la table benevolat qui contient
    les dates de la amnifestation
  */
  function premierjour return  timestamp
  is
    lepremierjour datebenevolat.datebenevolat%type;
  begin
    select min(datebenevolat) into lepremierjour from datebenevolat;
    return lepremierjour;
  exception
    when others then
      raise_application_error(-20999, 'erreur � la recherche du premier jour');
  end premierjour;
    /*
    cette fonction retourne le dernier jour de la manifestation.
    On peut le r�cup�rer grace � la table benevolat qui contient
    les dates de la amnifestation
  */
  function dernierjour return  timestamp
  is
    ledernierjour datebenevolat.datebenevolat%type;
  begin
    select max(datebenevolat) into ledernierjour from datebenevolat;
    return ledernierjour;
  exception
    when others then
      raise_application_error(-20999, 'erreur � la recherche du dernier jour');
  end dernierjour;
  
function dureevacation return integer
is
  vduree integer;
  begin
    select duree into vduree from parametres;
    return vduree;
  exception
    when others then
      raise_application_error(-20999, 'erreur � la lecture du param�tre');
  end dureevacation;

function recuperenbmaxatelier return integer
is
  vnb integer;
  begin
    select nbateliermax into vnb from parametres;
    return vnb;
  exception
    when others then
      raise_application_error(-20999, 'erreur � la lecture du param�tre');
end recuperenbmaxatelier;

function newidatelier return integer
is 
vnb integer;
begin 
    select coalesce(max(id), 0) into vnb from atelier;
    return vnb+1;
  exception
    when others then
      raise_application_error(-20999, 'erreur � la lecture du param�tre');
end newidatelier;


end fonctionsdiverses;

/
-- -----------------------------------------------------------------------------
--      FIN PACKAGE fonctionsdiverses
----------------------------------------------------------------
--
--
-- -----------------------------------------------------------------------------
--       PACKAGE PCKATELIER
--------------------------------------------------------------------------------
--       PACKAGE PCKATELIER ENTETE
--
create or replace
package pckatelier
is
-- d�claration d'un type tableau de chaines de caract�res 
type tchaine IS TABLE OF atelier.libelleatelier%type  INDEX BY pls_integer range 0..9;
-- d�claration d'un type tableau de timestamp 
-- on ne s'en est pas servi car C# a du mal � faire passer un tableau DateTime en param�tre � une proc�dure stock�e qui 
-- attend des timestamp. On laisse pour la V2
type tdateheure IS TABLE OF VACATION.HEUREDEBUT%type  INDEX BY pls_integer range 0..9;
/*
Proc�dure qui va cr�er un atelier avec des th�mes et des vacations pass�s en param�tre.
A la cr�ation d'un atelier, on doit obligatoirement passer  un th�me et une vacation
pour respecter le mod�le de donn�es fourni (voir cardinalit�s 1,n)
*/
procedure creerAtelier(plibelleatelier varchar ,pnbplacesmaxi atelier.NBPLACESMAXI%type, plesthemes tchaine, plesvacationsdebut tchaine, plesvacationsfin tchaine  );
/*
proc�dure permettant d'ajouter un th�me � un atelier dont l'id est fourni en param�tre
Le num�ro du th�me pour cet atelier est calcul� � ce niveau l�.
On g�re les remont�s d'exception
*/
procedure ajouttheme(pidAtelier atelier.id%type, plibelle theme.libelletheme%type);
/*
proc�dure permettant d'ajouter une vacation � un atelier dont l'id est pass� en param�re
Le num�ro de la vacation pour cet atelier est calcul� � ce niveau l�.
L'ordre d'insertion de la vacation va controler que la vacation ne chevauche pas une autre vacation du m�me atelier
On g�re les remont�s d'exception
*/
procedure ajoutvacation(pidAtelier atelier.id%type,pheuredebut vacation.heuredebut%type ,pheurefin vacation.heurefin%type );
/*
procedure qui va ajouter les th�mes pass�s en param�tre � l'atelier dont l'id est pass� en param�tre.
Cette proc�dure va boucler sur les th�mes pass�s en param�tre et appeler pour chacun la proc�dure ajouttheme
On g�re les remont�s d'exception. 
*/
procedure completethemeatelier(pidatelier atelier.id%type, plesthemes tchaine);
/*
procedure qui va ajouter les vacations pass�es en param�tre � l'atelier dont l'id est pass� en param�tre.
Cette proc�dure va boucler sur les vacations pass�s en param�tre et appeler pour chacun la proc�dure ajoutvacation
On g�re les remont�s d'exception. 
*/
procedure completevacationatelier(pidatelier atelier.id%type, plesvacationsdebut tchaine,plesvacationsfin tchaine );
/*
proc�dure qui va aller mettre � jour les vacations contenues dans la chaine pass�e en param�tre, pour l'atelier
pass� aussi en r�f�rence
On g�re les remont�s d'exception. 
*/
procedure modificationvacations(plesdatesdebut tchaine, plesdatesfin tchaine , pidatelier vacation.idatelier%type);


end pckatelier;




/
--
--		  fin PACKAGE PCKATELIER ent�te
--
--       PACKAGE PCKATELIER BODY
--
create or replace
package body pckatelier
is
/*
Proc�dure qui va cr�er un atelier avec des th�mes et des vacations pass�s en param�tre.
A la cr�ation d'un atelier, on doit obligatoirement passer  un th�me et une vacation
pour respecter le mod�le de donn�es fourni (voir cardinalit�s 1,n)
*/
procedure creerAtelier(plibelleatelier varchar ,pnbplacesmaxi atelier.NBPLACESMAXI%type,   plesthemes tchaine, plesvacationsdebut tchaine, plesvacationsfin tchaine )
is 
newid atelier.id%type;
--dateheurevacation vacation.heuredebut%type;
erreurtheme exception;
erreurvacation exception;
tropdatelier exception;
memetemps exception;
pragma exception_init (memetemps, -20203);
pragma exception_init (erreurtheme, -20201);
pragma exception_init (erreurvacation, -20202);
pragma exception_init (tropdatelier,-20204);
Begin
  --select SEQATELIER.NEXTVAL into newid from dual;
  -- r�cup�ration de l'id atelier � cr�er
  select fonctionsdiverses.newidatelier into newid from dual;
  insert into atelier(id, LIBELLEATELIER,NBPLACESMAXI)   
  values (newid, plibelleatelier,pnbplacesmaxi);

      FOR i IN plesthemes.FIRST .. plesthemes.LAST 
    LOOP
      ajouttheme(newid, plesthemes(i));
    END LOOP;

    
    FOR i IN plesvacationsdebut.FIRST .. plesvacationsdebut.LAST 
    LOOP
      ajoutvacation(newid, to_date(plesvacationsdebut(i),'DD/MM/YYYY HH24:MI:SS'), to_date(plesvacationsfin(i),'DD/MM/YYYY HH24:MI:SS'));
    END LOOP  ;
    
exception
  when erreurtheme then
    raise_application_error(-20201, 'Erreur � l''insertion du th�me');
  when erreurvacation then
    raise_application_error(-20202, 'Erreur � l''insertion d''une vacation');  
  when tropdatelier then
    raise_application_error(-20205, 'Il ne peut y avoir plus de 6 ateliers');
  when memetemps then
    raise_application_error(-20203, 'Deux vacations d''un m�me atelier ne peuvent avoir lieu en m�me temps');
  when others then
  raise_application_error(-20999, sqlerrm);
end  creerAtelier;
/*
proc�dure permettant d'ajouter un th�me � un atelier dont l'id est fourni en param�tre
Le num�ro du th�me pour cet atelier est calcul� � ce niveau l�.
On g�re les remont�s d'exception
*/
procedure ajouttheme(pidAtelier atelier.id%type, plibelle theme.libelletheme%type)
is
  nb theme.numero%type;
begin
  select coalesce(max(numero)+1, 1) into nb from theme where idatelier=pidAtelier;  
  insert into theme (idatelier, numero, libelletheme) values (pidAtelier,nb, plibelle);
exception
  when others then raise_application_error(-20201, 'Erreur � l''insertion du th�me');  
end ajouttheme;
/*
proc�dure permettant d'ajouter une vacation � un atelier dont l'id est pass� en param�re
Le num�ro de la vacation pour cet atelier est calcul� � ce niveau l�.
L'ordre d'insertion de la vacation va controler que la vacation ne chevauche pas une autre vacation du m�me atelier
On g�re les remont�s d'exception
*/
procedure ajoutvacation(pidAtelier atelier.id%type,pheuredebut vacation.heuredebut%type ,pheurefin vacation.heurefin%type)
is
  nb vacation.numero%type;
  memetemps exception;
  pragma exception_init(memetemps,-20203);
begin
  select coalesce(max(numero)+1 ,1)  into nb from vacation where idatelier=pidAtelier; 
  insert into vacation(idatelier,numero,heuredebut, heurefin) values (pidAtelier, nb,pheuredebut  ,pheurefin);
exception
  when memetemps then
    raise_application_error(-20203, 'Deux vacations d''un m�me atelier ne peuvent avoir lieu en m�me temps');
  when others 
    then raise_application_error(-20202, 'Erreur � l''insertion d''une vacation');  
end ajoutvacation;
/*
procedure qui va ajouter les th�mes pass�s en param�tre � l'atelier dont l'id est pass� en param�tre.
Cette proc�dure va boucler sur les th�mes pass�s en param�tre et appeler pour chacun la proc�dure ajouttheme
On g�re les remont�s d'exception. 
*/
procedure completethemeatelier(pidatelier atelier.id%type, plesthemes tchaine)
is
erreurtheme exception;
pragma exception_init (erreurtheme, -20201);
begin
    FOR i IN plesthemes.FIRST .. plesthemes.LAST 
    LOOP
      ajouttheme(pidatelier, plesthemes(i));
    END LOOP;
exception
  when erreurtheme then
    raise_application_error(-20201, 'Erreur � l''insertion du th�me');
  when others then
  raise_application_error(-20999, sqlerrm);
end;

/*
procedure qui va ajouter les vacations pass�es en param�tre � l'atelier dont l'id est pass� en param�tre.
Cette proc�dure va boucler sur les vacations pass�s en param�tre et appeler pour chacun la proc�dure ajoutvacation
On g�re les remont�s d'exception. 
*/
procedure completevacationatelier(pidatelier atelier.id%type, plesvacationsdebut tchaine, plesvacationsfin tchaine)
is
erreurvacation exception;
pragma exception_init (erreurvacation, -20202);
memetemps exception;
pragma exception_init (memetemps, -20203);
dateheurevacation vacation.heuredebut%type;
begin
    FOR i IN plesvacationsdebut.FIRST .. plesvacationsdebut.LAST 
    LOOP
      ajoutvacation(pidatelier, to_date(plesvacationsdebut(i),'DD/MM/YYYY HH24:MI:SS'), to_date(plesvacationsfin(i),'DD/MM/YYYY HH24:MI:SS'));
    END LOOP  ;
exception
   when memetemps then
    raise_application_error(-20203, 'Deux vacations d''un m�me atelier ne peuvent avoir lieu en m�me temps');
  when erreurvacation then
    raise_application_error(-20202, 'Erreur � l''insertion d''une vacation');     
  when others then
    raise_application_error(-20999, sqlerrm);
end;

/*
proc�dure priv�e du package permettant de modifier la date et l'heure d'une vacation d'un atelier 
Le trigger qui v�rifiera que les vacations d'un m�me atelier ne se d�clenchera pas sur le update (probl�me table mutante)
pour la v�rification, on a �crit un trigger par ordre after le update. C'est tr�s lourd, mais il y aura tr�s peu de modifications.
*/
procedure modificationunevacation(pidatelier vacation.idatelier%type, pnumero vacation.numero%type,pheured vacation.heuredebut%type,pheuref vacation.heurefin%type)
is
memetemps exception;
pragma exception_init (memetemps, -20203);
--pragma autonomous_transaction;
begin
  update vacation set heuredebut= pheured,heurefin= pheuref
    where idatelier=pidatelier
      and numero= pnumero;
  commit;
 exception 
  when memetemps then
    raise_application_error(-20203, 'Deux vacations d''un m�me atelier ne peuvent avoir lieu en m�me temps');
  when others then
    raise_application_error(-20202, 'Erreur � la mise � jour d''une vacation'); 
end modificationunevacation;

/*
proc�dure qui va aller mettre � jour les vacations contenues dans la chaine pass�e en param�tre, pour l'atelier
pass� aussi en r�f�rence
On g�re les remont�s d'exception. 
*/
procedure modificationvacations(plesdatesdebut tchaine, plesdatesfin tchaine , pidatelier vacation.idatelier%type)
is
memetemps exception;
pragma exception_init (memetemps, -20203);
begin
      FOR i IN plesdatesdebut.FIRST .. plesdatesdebut.LAST LOOP   
        modificationunevacation(pidatelier,i,to_date(plesdatesdebut(i),'DD/MM/YYYY HH24:MI:SS'), to_date(plesdatesfin(i),'DD/MM/YYYY HH24:MI:SS'));
    END LOOP ;
Exception
   when memetemps then
    raise_application_error(-20203, 'Deux vacations d''un m�me atelier ne peuvent avoir lieu en m�me temps');
  when others then
    raise_application_error(-20202, sqlerrm);
end modificationvacations;

end pckatelier;

/
-- -----------------------------------------------------------------------------
--      FIN PACKAGE PCKATELIER
----------------------------------------------------------------
--
--
-- -----------------------------------------------------------------------------
--       PACKAGE PCKPARTICIPANT
--------------------------------------------------------------------------------
--       PACKAGE PCKPARTICIPANT ENTETE
--
create or replace
package pckparticipant
is

type tids IS TABLE OF integer  INDEX BY pls_integer range 0..9;
type tchars4 IS TABLE OF char(4)  INDEX BY pls_integer range 0..9;
type tchars1 IS TABLE OF char(1)  INDEX BY pls_integer range 0..9;
--type collection IS REF CURSOR ;
--type tids IS TABLE OF integer  INDEX BY pls_integer range 0..9;
/*
*/
procedure NOUVEAULicencie(
  pNom participant.nomparticipant%type,
  pPrenom participant.prenomparticipant%type,
  pAdr1 participant.adresseparticipant1%type,
  pAdr2 participant.adresseparticipant2%type,
  pCp participant.cpparticipant%type,
  pVille participant.villeparticipant%type,
  pTel participant.telparticipant%type,
  pMail participant.mailparticipant%type,  
  pLicence benevole.numerolicence%type,
  pQualite qualite.id%type,
  pLesAteliers tids,
  pNumCheque paiement.numerocheque%type,
  pMontantCheque paiement.montantcheque%type,
  pTypePaiement paiement.typepaiement%type
  );
procedure NOUVEAUBENEVOLE(
  pNom participant.nomparticipant%type,
  pPrenom participant.prenomparticipant%type,
  pAdr1 participant.adresseparticipant1%type,
  pAdr2 participant.adresseparticipant2%type,
  pCp participant.cpparticipant%type,
  pVille participant.villeparticipant%type,
  pTel participant.telparticipant%type,
  pMail participant.mailparticipant%type,
  pDateNaiss benevole.datenaissance%type,
  pLicence Licencie.numerolicence%type,
  pLesdates tids
  );
  procedure NOUVELINTERVENANT(
  pNom participant.nomparticipant%type,
  pPrenom participant.prenomparticipant%type,
  pAdr1 participant.adresseparticipant1%type,
  pAdr2 participant.adresseparticipant2%type,
  pCp participant.cpparticipant%type,
  pVille participant.villeparticipant%type,
  pTel participant.telparticipant%type,
  pMail participant.mailparticipant%type,  
  pidatelier atelier.id%type,
  pstatutintervenant statut.id%type
  );
procedure NOUVELINTERVENANT(
  pNom participant.nomparticipant%type,
  pPrenom participant.prenomparticipant%type,
  pAdr1 participant.adresseparticipant1%type,
  pAdr2 participant.adresseparticipant2%type,
  pCp participant.cpparticipant%type,
  pVille participant.villeparticipant%type,
  pTel participant.telparticipant%type,
  pMail participant.mailparticipant%type,  
  pidatelier atelier.id%type,
  pstatutintervenant statut.id%type,
  plescategories tchars1,
  pleshotels tchars4,
  plesnuits tids
  );

procedure ENREGISTREPAIEMENT(
  pLicencie Licencie.idLicencie%type,
  pNumCheque paiement.numerocheque%type,  
  pMontantCheque paiement.montantcheque%type,
  pTypePaiement paiement.typepaiement%type); 

end pckparticipant;
/
--
--		  fin PACKAGE PCKPARTICIPANT ent�te
--
--       PACKAGE PCKPARTICIPANT BODY
--
create or replace
package body pckparticipant
is
erreur exception;
/*
  Cr�ation d'une proc�dure priv�e qui va paermetre d'ins�rer une ligne dans la table participant
  Cette proc�dure est appel�e par las proc�dures :
  -nouveaubenevole,
  -nouveaulicenci�,
  -nouveauintervenant
  - le param�tre newid est un param�tre out pour renvoyer � la proc�dure appelante 
  l'id du participant cr��. Cela �vie dans les proc�dures appemantes d'avoir acc�s � la sesxxx.currval, car le currval ramen� pourrait
  �tre diff�rent de l'id du participant si qq a entre temps cr�� un nouveau participant
*/
  procedure creerparticipant(
  pNom participant.nomparticipant%type,
  pPrenom participant.prenomparticipant%type,
  pAdr1 participant.adresseparticipant1%type,
  pAdr2 participant.adresseparticipant2%type,
  pCp participant.cpparticipant%type,
  pVille participant.villeparticipant%type,
  pTel participant.telparticipant%type,
  pMail participant.mailparticipant%type,
  newid out participant.id%type)
  is  
  Begin
        insert into participant(id, nomparticipant, prenomparticipant, adresseparticipant1, adresseparticipant2,cpparticipant, villeparticipant,telparticipant, mailparticipant, dateinscription)
        values (seqparticipant.nextval, pNom,pPrenom,pAdr1,pAdr2,pCp,pVille,pTel,pMail, sysdate);
        newid:=seqparticipant.currval;  
Exception
  when others then
    raise_application_error(-20100, 'Erreur � la cr�ation du participant ');
end creerparticipant;
 
 /*
 La proc�dure NOUVELicencieIE va 
 1- cr�er un nouveau participant en appelent la proc�dure creerparticipant
 2- cr�er un enregistrement dans la table licenci�
 3- enregistrer le paiement, OBLIGATOIRE � ce moment l�.
 Ce paiement peut �tre ici : inscription ou tout
 */
 /*
proc�dure priv�e quii va inscrire un intervenant dans la table intervenant.
L'insertion d�clenchera un trigger qui v�rifiera si l'intervenant est animateur pour l'atelier choisi, 
et donc qu'il n'y a pas d�j� un animateur pour cet atelier
*/
procedure creerintervenant(pidatelier atelier.id%type, pstatutintervenant statut.id%type, newid participant.id%type )
is
dejaanimateur exception;
pragma exception_init(dejaanimateur, -20112);
begin
    insert into intervenant(idintervenant, idatelier, idstatut) values(newid,pidatelier,pstatutintervenant);
Exception
    when dejaanimateur then
      raise_application_error(-20112 ,'cet atelier a d�j� son animateur, inscription impossible');
    when others then
      raise_application_error(-20102, 'Erreur � la cr�ation de l''intervenant');
end;

procedure creercontenuhebergement(plescategories tchars1, pleshotels tchars4, plesnuits tids, newid participant.id%type)
is
vnumordre number(1) :=0;
begin
  FOR i IN plescategories.FIRST .. plescategories.LAST 
  LOOP
      vnumordre:=vnumordre + 1;
      insert into contenuhebergement(idparticipant, numordre,codehotel, idcategorie, iddatearriveenuitee)
       values (newid, vnumordre, pleshotels(i) ,plescategories(i), plesnuits(i));   
  END LOOP;
Exception
   when others then
      raise_application_error(-20104, 'Erreur � la cr�ation du contenu de l''h�bergement');  
end creercontenuhebergement;
/*

*/
 procedure NOUVEAULicencie(
  pNom participant.nomparticipant%type,
  pPrenom participant.prenomparticipant%type,
  pAdr1 participant.adresseparticipant1%type,
  pAdr2 participant.adresseparticipant2%type,
  pCp participant.cpparticipant%type,
  pVille participant.villeparticipant%type,
  pTel participant.telparticipant%type,
  pMail participant.mailparticipant%type,
  pLicence benevole.numerolicence%type,
  pQualite qualite.id%type,
  pLesAteliers tids,
  pNumCheque paiement.numerocheque%type,
  pMontantCheque paiement.montantcheque%type,
  pTypePaiement paiement.typepaiement%type
  )
  is
  tropdateliers Exception;
  errparticipant Exception;
   pragma exception_init(tropdateliers, -20001);
   pragma exception_init(errparticipant, -20100);
   newid participant.id%type;

  begin
    creerparticipant(pNom,pPrenom,pAdr1,pAdr2,pCp,pVille,pTel,pMail,newid );
    insert into Licencie(idLicencie, idqualite, numerolicence) 
        values(newid, pQualite, pLicence);
    enregistrepaiement(seqpaiement.nextval,newid ,pMontantCheque, pTypePaiement);
    FOR i IN pLesAteliers.FIRST .. pLesAteliers.LAST 
    LOOP
      insert into inscrire(idparticipant, idatelier) values (newid, pLesAteliers(i));
    END LOOP;

  exception
    when tropdateliers then
      raise_application_error(-20001 , 'Inscription impossible, nombre d''ateliers limit� � 5');
    when errparticipant then
      raise_application_error(-20100 , 'Erreur � la cr�ation du participant ');
    when others then
      raise_application_error(-20103, 'erreur � la cr�ationLicenciencie ');        
  end;
 /*
 La proc�dure ENREGISTREPAIEMENT va enregistrer le paiement d'un congressiste.
 Elle peut �tre appel�e par la proc�dure NLicencieCENCIE dans le cas de l'inscription d'un licenci�
 ou encore directement du programme pour l'enregistrement d'un accompagnant.
 */
  
  procedure ENREGISTREPAIEMENT(
  pLicencie Licencie.idLicencie%type,
  pNumCheque paiement.numerocheque%type,  
  pMontantCheque paiement.montantcheque%type,
  pTypePaiement paiement.typepaiement%type)
  is
  begin
    null;
  end;
  procedure creerbenevole (pLicence benevole.numerolicence%type,  pdatenaiss benevole.datenaissance%type, newid participant.id%type)
  is
  benevdejainscrit exception;
    pragma exception_init(benevdejainscrit, -20110);
  begin
    insert into benevole(idbenevole, numerolicence, datenaissance)
      values(newid, pLicence, pdatenaiss);
  EXCEPTION
    when benevdejainscrit then
      raise_application_error(-20110 , 'b�n�vole d�j� inscrit, vous devez faire une modification de b�n�vole');
    when others then
      raise_application_error(-20101 , 'Erreur � la cr�ation du b�n�vole');
  end;
  
  procedure creeretrepresent(pLesdates tids, newid participant.id%type)
  is
  begin
    FOR i IN pLesdates.FIRST .. pLesdates.LAST 
    LOOP
      insert into etrepresent(idbenevole, IDDATEPRESENT) values (newid, pLesdates(i));
    END LOOP;
  EXCEPTION
    when others then
      raise_application_error(-20105 , 'Erreur � la cr�ation des pr�sences du b�n�vole');
  end creeretrepresent;
  
  procedure NOUVEAUBENEVOLE( 
  pNom participant.nomparticipant%type,
  pPrenom participant.prenomparticipant%type,
  pAdr1 participant.adresseparticipant1%type,
  pAdr2 participant.adresseparticipant2%type,
  pCp participant.cpparticipant%type,
  pVille participant.villeparticipant%type,
  pTel participant.telparticipant%type,
  pMail participant.mailparticipant%type,
  pDateNaiss benevole.datenaissance%type,
  pLicence Licencie.numerolicence%type,
  pLesdates tids
  )
  is 
  newid participant.id%type;
  erreurbenevole exception;
  errparticipant exception;
  erreurpresencebenevole exception;
  benevdejainscrit exception;
  pragma exception_init(errparticipant, -20100);
  pragma exception_init(erreurbenevole, -20101);
  pragma exception_init(benevdejainscrit, -20110);
  pragma exception_init(erreurpresencebenevole, -20105);
  begin
    creerparticipant(pNom,pPrenom,pAdr1,pAdr2,pCp,pVille,pTel,pMail, newid );
    creerbenevole(plicence, pdatenaiss, newid);
    creeretrepresent(pLesdates, newid);
  exception
      when errparticipant then
        raise_application_error(-20100 , 'Erreur � la cr�ation du participant ');
      when benevdejainscrit then
        raise_application_error(-20110 , 'b�n�vole d�j� inscrit, \n vous devez faire une modification de b�n�vole');
      when erreurbenevole then
        raise_application_error(-20101 , 'Erreur � la cr�ation du benevole ');
      when others then
        raise_application_error(-20202, 'erreur inattendue lors de la cr�ation d''un b�n�vole');  
end;


/*
Proc�dure qui inscrit un intervenant sans nuit�
*/
procedure NOUVELINTERVENANT(
  pNom participant.nomparticipant%type,
  pPrenom participant.prenomparticipant%type,
  pAdr1 participant.adresseparticipant1%type,
  pAdr2 participant.adresseparticipant2%type,
  pCp participant.cpparticipant%type,
  pVille participant.villeparticipant%type,
  pTel participant.telparticipant%type,
  pMail participant.mailparticipant%type,  
  pidatelier atelier.id%type,
  pstatutintervenant statut.id%type
  )
  is
  newid participant.id%type;
  erreurparticipant Exception;
  erreurintervenant Exception;
  dejaanimateur Exception;
  pragma exception_init(dejaanimateur, -20112);
  pragma exception_init(erreurparticipant, -20100);
  pragma exception_init(erreurintervenant, -20102);
  begin
    creerparticipant(pNom,pPrenom,pAdr1,pAdr2,pCp,pVille,pTel,pMail,newid );
    creerintervenant(pidatelier,pstatutintervenant, newid);  
exception
    when erreurparticipant then
      raise_application_error(-20100, 'erreur � la cr�ation du participant');
    when erreurintervenant then
      raise_application_error(-20102, 'erreur � la cr�ation de l''intervenant ');
    when dejaanimateur then
      raise_application_error(-20112,'cet atelier a d�j� son animateur, inscription impossible');
    when others then
      raise_application_error(-20203, 'Autre erreur innattendue lors de la cr�ation d''un intervenant');
  end;



/*
Proc�dure qui inscrit un intervenant avec nuit�
Cette proc�dure va faire appel � la proc�dure surcharg�e NOUVELINTERVENANT
*/
procedure NOUVELINTERVENANT(
  pNom participant.nomparticipant%type,
  pPrenom participant.prenomparticipant%type,
  pAdr1 participant.adresseparticipant1%type,
  pAdr2 participant.adresseparticipant2%type,
  pCp participant.cpparticipant%type,
  pVille participant.villeparticipant%type,
  pTel participant.telparticipant%type,
  pMail participant.mailparticipant%type,  
  pidatelier atelier.id%type,
  pstatutintervenant statut.id%type,
  plescategories tchars1,
  pleshotels tchars4,
  plesnuits tids
  )
  is
  newid participant.id%type;
  erreurparticipant Exception;
  erreurintervenant Exception;
  erreurcontenuhebergement Exception;
  dejaanimateur Exception;
  pragma exception_init(erreurparticipant, -20100);
  pragma exception_init(erreurintervenant, -20102);
  pragma exception_init(erreurcontenuhebergement, -20104);
  pragma exception_init(dejaanimateur, -20110);  
  begin
    creerparticipant(pNom,pPrenom,pAdr1,pAdr2,pCp,pVille,pTel,pMail, newid);
    creerintervenant(pidatelier,pstatutintervenant, newid); 
    creercontenuhebergement(plescategories,pleshotels,plesnuits, newid);
exception
    when erreurparticipant then
      raise_application_error(-20100, 'erreur � la cr�ation du participant');
    when erreurintervenant then
      raise_application_error(-20102, 'erreur � la cr�ation de l''intervenant ');
    when erreurcontenuhebergement then
      raise_application_error(-20104,'Erreur � la cr�ation du contenu de l''h�bergement');
    when dejaanimateur then
      raise_application_error(-20112,'cet atelier a d�j� son animateur, inscription impossible');
    when others then
      raise_application_error(-20203, 'Autre erreur innattendue lors de la cr�ation d''un intervenant');
  end;

end pckparticipant;
/
-- -----------------------------------------------------------------------------
--      FIN PACKAGE PCKPARTICIPANT
----------------------------------------------------------------
--

-- -----------------------------------------------------------------------------
--      FIN PACKAGE PCKPARTICIPANT
----------------------------------------------------------------
--

--
-- -----------------------------------------------------------------------------
--       Cr�ation des synonymes publics pour masquer � l'utilisateur le sch�ma d'appartenance
--------------------------------------------------------------------------------
create public synonym fonctionsdiverses for mdl.fonctionsdiverses;
create public synonym pckatelier for mdl.pckatelier;
create public synonym pckparticipant for mdl.pckparticipant;



