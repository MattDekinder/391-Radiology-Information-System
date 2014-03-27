drop index DESCRIPTION_INDEX;
drop index DIAGNOSIS_INDEX;
drop index FIRSTNAME_INDEX;
drop index LASTNAME_INDEX;

create index DESCRIPTION_INDEX on RADIOLOGY_RECORD(description) indextype is ctxsys.context;
create index DIAGNOSIS_INDEX on RADIOLOGY_RECORD(diagnosis) indextype is ctxsys.context;
create index FIRSTNAME_INDEX on PERSONS(first_name) indextype is ctxsys.context;
create index LASTNAME_INDEX on PERSONS(last_name) indextype is ctxsys.context;

--select (score(1)+score(2))*6, PERSON_ID from PERSONS where CONTAINS(FIRST_NAME, 'VERNON',1) > 0 or CONTAINS(LAST_NAME, 'RIGGS', 2) > 0;

--select score(1)*3+score(2), PATIENT_ID from RADIOLOGY_RECORD where CONTAINS(DIAGNOSIS, 'sed',1)>0 OR CONTAINS(DESCRIPTION, 'SED',2)>0;

--select (score(1)+score(2))*6+col, PERSON_ID 
--from PERSONS outer join (select (score(1)*3+score(2)) col, PATIENT_ID from RADIOLOGY_RECORD where CONTAINS(DIAGNOSIS, 'VERNON',1)>-99999 OR CONTAINS(DESCRIPTION, 'VERNON',2)>-99999) actionword on actionword.PATIENT_ID = PERSON_ID
--where CONTAINS(FIRST_NAME, 'VERNON',1) > -9999 or CONTAINS(LAST_NAME, 'RIGGS', 2) > -99999;


