
insert into Categoriechambre (libelleCategorie) values ('Single');
insert into Categoriechambre (libelleCategorie) values ('Double');

insert into Vacation(libelle, dateheuredebut, dateheurefin) values('le 14 septembre de 8:00 à 10:00', '2021-09-14 08:00:00', '2021-09-14 10:00:00');
insert into Vacation(libelle, dateheuredebut, dateheurefin) values('le 14 septembre de 14:00 à 18:00', '2021-09-14 14:00:00', '2021-09-14 18:00:00');

insert into Atelier(libelle, idvacation, nbplacemaxi) values('LE Club ET SON PROJET', 1, 60);
insert into Atelier(libelle, idvacation, nbplacemaxi) values('LE FONCTIONNEMENT DU Club', 1, 80);
insert into Atelier(libelle, idvacation, nbplacemaxi) values('LES OUTILS À DISPOSITION ET REMIS AUX ClubS', 2, 110);
insert into Atelier(libelle, idvacation, nbplacemaxi) values('OBSERVATOIRE DES MÉTIERS DE LESCRIME', 2, 60);
insert into Atelier(libelle, idvacation, nbplacemaxi) values('I. F. F. E', 1, 70);
insert into Atelier(libelle, idvacation, nbplacemaxi) values('DÉVELOPPEMENT DURABLE', 2, 60);

INSERT INTO Hotel
   (NOMHOTEL, ADRESSE1,ADRESSE2 ,CP,VILLE,TEL,MAIL) 
   VALUES ('Hôtel ibis Lille Centre Gares','29, Av Charles St-Venant','Le Forum','59000','LILLE','(+33)3/28363040','H0901@accor.com') ;
INSERT INTO Hotel
   (NOMHOTEL, ADRESSE1,ADRESSE2 ,CP,VILLE,TEL,MAIL) 
   VALUES ('Hôtel Novotel Lille Centre Grand Place','116 rue de l''Hopital Militaire',null,'59000','LILLE','(+33)3/28385353','H0918@accor.com') ;



INSERT INTO Proposer (idcategorie, idhotel, TARIFNUITEE) VALUES(1,1,61.20 );   
INSERT INTO Proposer (idcategorie, idhotel, TARIFNUITEE) VALUES(2,1,62.20 ); 
INSERT INTO Proposer (idcategorie, idhotel, TARIFNUITEE) VALUES(1,2,112.00 ); 
INSERT INTO Proposer (idcategorie, idhotel, TARIFNUITEE) VALUES(2,2,122.00 );    


commit;