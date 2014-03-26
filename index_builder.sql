create index DESCRIPTION_INDEX on RADIOLOGY_RECORD(description) indextype is ctxsys.context;
create index DIAGNOSIS_INDEX on RADIOLOGY_RECORD(diagnosis) indextype is ctxsys.context;
create index FIRSTNAME_INDEX on PERSONS(first_name) indextype is ctxsys.context;
create index LASTNAME_INDEX on PERSONS(last_name) indextype is ctxsys.context;

