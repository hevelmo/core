CREATE VIEW v_camModelosMarcas
AS
  SELECT * 
  FROM camModelosMarcas mrm
  LEFT JOIN camMarcas mar
  ON mrm.MRM_MAR_Id = mar.MAR_Id
  LEFT JOIN camModelos mdo
  ON mrm.MRM_MDO_Id = mdo.MDO_Id