CREATE VIEW v_camSeminuevos
AS
  SELECT *
  FROM camSeminuevos sen
  INNER JOIN camAgencias agn
  ON sen.SEN_AGN_Id = agn.AGN_Id
  INNER JOIN camTelefonos tel
  ON agn.AGN_Id = tel.TEL_AGN_Id
  INNER JOIN camCategorias cat
  ON sen.SEN_CAT_Id = cat.CAT_Id
  INNER JOIN camMarcas mar
  ON sen.SEN_MAR_Id = mar.MAR_Id
  INNER JOIN camModelos mdo
  ON sen.SEN_MDO_Id = mdo.MDO_Id
  WHERE AGN_Tipo = 0