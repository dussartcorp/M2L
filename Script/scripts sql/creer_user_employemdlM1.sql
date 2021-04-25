-- -----------------------------------------------------------------------------
--             G�n�ration d'une base de donn�es pour
--                      Oracle Version 11g XE
--                        
-- -----------------------------------------------------------------------------
--      Projet : MaisonDesLigues
--      Auteur : Beno�t ROCHE
--      Date de derni�re modification : 9/01/2013 11:32:40
-- -----------------------------------------------------------------------------

-- -----------------------------------------------------------------------------
--      Partie 1: Cr�ation de l'utilisateur MDL qui sera aussi le propri�taire
-- 		des objets : tables, index, proc�dures
--		
--		Ce script doit �tre ex�cut� par un utilisateur poss�dant le droit de cr�er un utilisateur.
--		Par exemple l'utilisateur SYSTEM
-- -----------------------------------------------------------------------------
--
--      On commence par supprimer l'utilisateur avant de le recr�er
-- -
-- 
drop user employemdl cascade ;
create user employemdl identified by employemdl 
ACCOUNT UNLOCK ;

-- Droits ... il faudra en rajouter certainement
GRANT create session TO employemdl;


-- on va cr�er un r�le : ensemble de droits et on va attribuer ce role � l'employe mdl
drop role applimdl;
create role applimdl;
GRANT create session TO applimdl;
grant execute on mdl.pckparticipant to applimdl; -- autorisation d'ex�cuter toutes les proc�dures et fonctions publiques du package
grant select on mdl.VRESTAURATION01  to applimdl;
grant select on mdl.VQUALITE01  to applimdl;
grant select on mdl.VDATEBENEVOLAT01  to applimdl;
grant select on mdl.VDATENuitee01  to applimdl;
grant select on mdl.VDATENuitee02  to applimdl;
grant select on mdl.VHOTEL01  to applimdl;
grant select on mdl.VCATEGORIECHAMBRE01  to applimdl;
grant select on mdl.VSTATUT01  to applimdl;
grant select on mdl.VATELIER01  to applimdl;
grant select on mdl.VATELIER02  to applimdl ;
grant select on mdl.VVACATION01  to applimdl ;
grant execute on mdl.pckatelier to applimdl;
grant execute on mdl.fonctionsdiverses to applimdl;

-- attribution du role � employemdl
grant applimdl to employemdl;
