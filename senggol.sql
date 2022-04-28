CREATE TABLE pendaftar (
  idpendaftar  int AUTO_INCREMENT NOT NULL,
  tahun        int(4) NOT NULL,
  bulan        int(2) NOT NULL,
  nik          varchar(16) NOT NULL,
  nama         varchar(50) NOT NULL,
  alamat       varchar(200) NOT NULL,
  surel        varchar(50) DEFAULT NULL,
  /* Keys */
  PRIMARY KEY (idpendaftar)
) ENGINE = InnoDB;

CREATE UNIQUE INDEX pendaftar_index01
  ON pendaftar
  (tahun, bulan, nik);