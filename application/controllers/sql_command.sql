

-- grant access on other schema
BEGIN
  FOR obj IN (SELECT table_name FROM all_tables WHERE owner = 'IPAS') LOOP
    EXECUTE IMMEDIATE 'GRANT SELECT, INSERT, UPDATE, DELETE ON IPAS.' || obj.table_name || ' TO JOMELDEV';
  END LOOP;
END;


-- grant user to execute the package to other schema.
GRANT EXECUTE ON PMIS.HCP_STATUS TO ipas;


