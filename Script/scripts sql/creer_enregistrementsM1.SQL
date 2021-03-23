-- -----------------------------------------------------------------------------
--             Génération d'une base de données pour
--                      Oracle Version 11g XE
--                        
-- -----------------------------------------------------------------------------
--      Projet : MaisonDesLigues
--      Auteur : Benoît ROCHE
--      Date de dernière modification : 9/01/2013 11:32:40
-- -----------------------------------------------------------------------------

-- -----------------------------------------------------------------------------
--      Partie 3: Création de l'utilisateur MDL qui sera aussi le propriétaire
-- 		des objets : tables, index, procédures
--
--		Ce script doit être exécuté par un l'utilisateur MDL
--		(celui qui a été créé dans le script creer_user)
-- 	Ce script doit être exécuté APRES le script creer_objets.sql
--- -----------------------------------------------------------------------------
-- -----------------------------------------------------------------------------
--


-- -----------------------------------------------------------------------------
--       TABLE : CATEGORIECHAMBRE
-- 
insert into CATEGORIECHAMBRE (LIBELLECATEGORIE) values ('Single');
insert into CATEGORIECHAMBRE (LIBELLECATEGORIE) values ('Double');

-- -----------------------------------------------------------------------------
--       TABLE : QUALITE
-- 
/*
-- insert into qualite(libellequalite) values ('Président de ligue');
-- insert into qualite(libellequalite) values ('Président de club');
-- insert into qualite(libellequalite) values ('Président de CD');
-- insert into qualite(libellequalite) values ('Vice-Président de ligue');
-- insert into qualite(libellequalite) values ('Vice-Président de club');
-- insert into qualite(libellequalite) values ('Vice-Président de CD');
-- insert into qualite(libellequalite) values ('secrétaire de ligue');
-- insert into qualite(libellequalite) values ('secrétaire de club');
-- insert into qualite(libellequalite) values ('secrétaire de CD');
-- insert into qualite(libellequalite) values ('Trésorier de ligue');
-- insert into qualite(libellequalite) values ('Trésorier de club');
-- insert into qualite(libellequalite) values ('Trésorier de CD');
-- insert into qualite(libellequalite) values ('Maitre d''armes');
-- insert into qualite(libellequalite) values ('Eleve Maitre');
-- insert into qualite(libellequalite) values ('Cadre Technique Régional');
-- insert into qualite(libellequalite) values ('Relais');
-- insert into qualite(libellequalite) values ('Coordinateur de Pôle');
-- insert into qualite(libellequalite) values ('Athlète de Haut Niveau');
-- insert into qualite(libellequalite) values ('TBenevole de Club');
-- insert into qualite(libellequalite) values ('Animateur');
-- insert into qualite(libellequalite) values ('FFE');
-- insert into qualite(libellequalite) values ('Trésorier de CD');
-- insert into qualite(libellequalite) values ('Autre');
*/

-- -----------------------------------------------------------------------------
--       TABLE : VACATION
--

insert into VACATION(dateheuredebut, dateheurefin) values('2021-03-27 08:00:00', '2021-03-27 10:00:00');
insert into VACATION(dateheuredebut, dateheurefin) values('2021-03-27 14:00:00', '2021-03-27 18:00:00');

-- -----------------------------------------------------------------------------
--       TABLE : ATELIER
--

insert into ATELIER(libelle, idvacation, nbplacemaxi) values('LE CLUB ET SON PROJET', 1, 60);
insert into ATELIER(libelle, idvacation, nbplacemaxi) values('LE FONCTIONNEMENT DU CLUB', 1, 80);
insert into ATELIER(libelle, idvacation, nbplacemaxi) values('LES OUTILS À DISPOSITION ET REMIS AUX CLUBS', 2, 110);
insert into ATELIER(libelle, idvacation, nbplacemaxi) values('OBSERVATOIRE DES MÉTIERS DE LESCRIME', 2, 60);
insert into ATELIER(libelle, idvacation, nbplacemaxi) values('I. F. F. E', 1, 70);
insert into ATELIER(libelle, idvacation, nbplacemaxi) values('DÉVELOPPEMENT DURABLE', 2, 60);

-- -----------------------------------------------------------------------------
--       TABLE : STATUT
--
/*
insert into STATUT(id, libellestatut) values('ANI', 'Animateur');
insert into STATUT(id, libellestatut) values('INT', 'Intervenant');
*/

-- -----------------------------------------------------------------------------
--       TABLE : RESTAURATION
--
/*
insert into RESTAURATION(daterestauration, typerepas) values('14/09/2013','midi');
insert into RESTAURATION(daterestauration, typerepas) values('14/09/2013','soir');
insert into RESTAURATION(daterestauration, typerepas) values('15/09/2013','midi');
*/

-- -----------------------------------------------------------------------------
--       TABLE : HOTEL
--
INSERT INTO HOTEL
   (NOMHOTEL, ADRESSE1,ADRESSE2 ,CP,VILLE,TEL,MAIL) 
   VALUES ('Hôtel ibis Lille Centre Gares','29, Av Charles St-Venant','Le Forum','59000','LILLE','(+33)3/28363040','H0901@accor.com') ;
INSERT INTO HOTEL
   (NOMHOTEL, ADRESSE1,ADRESSE2 ,CP,VILLE,TEL,MAIL) 
   VALUES ('Hôtel Novotel Lille Centre Grand Place','116 rue de l''Hopital Militaire',null,'59000','LILLE','(+33)3/28385353','H0918@accor.com') ;


  
-- -----------------------------------------------------------------------------
--       TABLE : NUITE
--
insert into NUITE(idhotel, DATENUITEE, idcategoriechambre) values(1,'2021-03-27 00:00:00',2);
insert into NUITE(idhotel, DATENUITEE, idcategoriechambre) values(1,'2021-03-26 00:00:00',1);


-- -----------------------------------------------------------------------------
--       TABLE : PROPOSER
-- -----------------------------------------------------------------------------

INSERT INTO PROPOSER (idcategorie, idhotel, TARIFNUITE) VALUES(1,1,61.20 );   
INSERT INTO PROPOSER (idcategorie, idhotel, TARIFNUITE) VALUES(2,1,62.20 ); 
INSERT INTO PROPOSER (idcategorie, idhotel, TARIFNUITE) VALUES(1,2,112.00 ); 
INSERT INTO PROPOSER (idcategorie, idhotel, TARIFNUITE) VALUES(2,2,122.00 );    

-- -----------------------------------------------------------------------------
--       TABLE : PARAMETRES
--
-- insert into parametres (nomddl, adrue1, adrue2, cp, ville, tel, fax, mail, tarifinscription, tarifrepasaccompagnant, duree, nbateliermax) 
--	values('maison des Ligues', '123 avenue des balladins', 'résidence du cirque', '83000', 'Toulon', '04 04 04 04 04','04 04 04 04 01','mdl@free.fr',100,35,90,6);


commit;