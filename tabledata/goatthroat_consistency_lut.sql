create table consistency_lut
(
    value       varchar(50) charset utf8mb4 null,
    replacement varchar(50) charset utf8mb4 null comment 'If replacement is null, the value will remain the same',
    constraint consistency_lut_value_uindex
        unique (value)
);

INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('N/r', '[n/r]');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Caution -', 'Caution');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Tygon 2375 Hose', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('None', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('2375 Hose By Tygon', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Best, But Not Recommended Because Too Viscous', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('N/a', '[n/r]');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('`best', 'Best');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Pvc', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Due Not Use', 'Do Not Use');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Do Not Usdo Not Usee', 'Do Not Use');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Best WithTef Kal Fluid Path Upgrade', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Best With Teflon Fluid Path Upgrade', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Gas Grad Hose', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('\\', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Tygon C-544-A1B', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('GOOD', 'Good');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('See Notes', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Too Thick For GT Pumps', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('N-r', '[n/r]');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Neither', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Flammable', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('2375', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('PtFE', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Viton Hose', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('BEST', 'Best');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Viton', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Depends On Other Consituents', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Tygon 2375', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Caution', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Fair', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Gas Grade Hose', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Do Not Use', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('2375 By Tygon', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('Tygon 200SE - Please Add Spring Guard', '');
INSERT INTO goatthroat.consistency_lut (value, replacement) VALUES ('[n/r]', '');