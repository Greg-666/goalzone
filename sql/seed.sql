-- ============================================
-- GoalZone - Coupe du monde 2026
-- Dump SQL complet : structure + données seed
-- Encodage : utf8mb4 | Moteur : InnoDB
-- ============================================
-- Nettoyage des tables avant import (ordre important à cause des FK)





SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS messages_contact;
DROP TABLE IF EXISTS favoris;
DROP TABLE IF EXISTS matchs;
DROP TABLE IF EXISTS joueurs;
DROP TABLE IF EXISTS equipes;
DROP TABLE IF EXISTS stades;
DROP TABLE IF EXISTS utilisateurs;
DROP TABLE IF EXISTS confederations;
DROP TABLE IF EXISTS groupes;

-- Création de la base si elle n'existe pas
CREATE DATABASE IF NOT EXISTS `5BX75_K7M_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `5BX75_K7M_db`;

-- ============================================
-- STRUCTURE DES TABLES
-- ============================================

-- Table des groupes (A à L)
CREATE TABLE IF NOT EXISTS groupes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom CHAR(1) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des confédérations
CREATE TABLE IF NOT EXISTS confederations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(10) NOT NULL UNIQUE,
    nom VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des équipes
CREATE TABLE IF NOT EXISTS equipes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    code_pays CHAR(3) NOT NULL,
    drapeau_url VARCHAR(255) DEFAULT NULL,
    groupe_id INT NOT NULL,
    confederation_id INT NOT NULL,
    FOREIGN KEY (groupe_id) REFERENCES groupes(id),
    FOREIGN KEY (confederation_id) REFERENCES confederations(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des joueurs
CREATE TABLE IF NOT EXISTS joueurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    poste ENUM('GB', 'DEF', 'MIL', 'ATT') NOT NULL,
    numero TINYINT DEFAULT NULL,
    equipe_id INT NOT NULL,
    FOREIGN KEY (equipe_id) REFERENCES equipes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des stades
CREATE TABLE IF NOT EXISTS stades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(150) NOT NULL,
    ville VARCHAR(100) NOT NULL,
    pays VARCHAR(50) NOT NULL,
    capacite INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des matchs
CREATE TABLE IF NOT EXISTS matchs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    equipe_dom_id INT NOT NULL,
    equipe_ext_id INT NOT NULL,
    stade_id INT NOT NULL,
    date_match DATETIME NOT NULL,
    score_dom TINYINT DEFAULT NULL,
    score_ext TINYINT DEFAULT NULL,
    phase ENUM('groupes', 'huitieme', 'quart', 'demi', 'finale_petite', 'finale') NOT NULL,
    apercu_ia TEXT DEFAULT NULL,
    apercu_genere BOOLEAN DEFAULT 0,
    FOREIGN KEY (equipe_dom_id) REFERENCES equipes(id),
    FOREIGN KEY (equipe_ext_id) REFERENCES equipes(id),
    FOREIGN KEY (stade_id) REFERENCES stades(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- ============================================
-- DONNÉES SEED
-- ============================================

-- Groupes (A à L)
INSERT INTO groupes (nom) VALUES
('A'), ('B'), ('C'), ('D'), ('E'), ('F'),
('G'), ('H'), ('I'), ('J'), ('K'), ('L');

-- Confédérations
INSERT INTO confederations (code, nom) VALUES
('UEFA', 'Union des associations européennes de football'),
('CONMEBOL', 'Confédération sud-américaine de football'),
('CAF', 'Confédération africaine de football'),
('AFC', 'Confédération asiatique de football'),
('CONCACAF', 'Confédération de football d\'Amérique du Nord, centrale et Caraïbes'),
('OFC', 'Confédération océanienne de football');

-- Stades (16 stades officiels)
INSERT INTO stades (nom, ville, pays, capacite) VALUES
('MetLife Stadium', 'New York / New Jersey', 'USA', 82500),
('AT&T Stadium', 'Dallas', 'USA', 80000),
('SoFi Stadium', 'Los Angeles', 'USA', 70240),
('Levi\'s Stadium', 'San Francisco', 'USA', 68500),
('Hard Rock Stadium', 'Miami', 'USA', 65326),
('Caesars Superdome', 'La Nouvelle-Orléans', 'USA', 73208),
('Arrowhead Stadium', 'Kansas City', 'USA', 76416),
('Lumen Field', 'Seattle', 'USA', 68740),
('Lincoln Financial Field', 'Philadelphie', 'USA', 69796),
('Gillette Stadium', 'Boston', 'USA', 65878),
('BC Place', 'Vancouver', 'Canada', 54500),
('BMO Field', 'Toronto', 'Canada', 45736),
('Stade Olympique', 'Montréal', 'Canada', 61004),
('Estadio Azteca', 'Mexico', 'Mexique', 87523),
('Estadio BBVA', 'Monterrey', 'Mexique', 53500),
('Estadio Akron', 'Guadalajara', 'Mexique', 49850);

-- Équipes qualifiées (48 équipes - groupes officiels et définitifs)
-- confederation_id : 1=UEFA, 2=CONMEBOL, 3=CAF, 4=AFC, 5=CONCACAF, 6=OFC

INSERT INTO equipes (nom, code_pays, drapeau_url, groupe_id, confederation_id) VALUES
-- Groupe A
('Mexique', 'MEX', 'https://flagcdn.com/mx.svg', 1, 5),
('Afrique du Sud', 'ZAF', 'https://flagcdn.com/za.svg', 1, 3),
('République de Corée', 'KOR', 'https://flagcdn.com/kr.svg', 1, 4),
('République tchèque', 'CZE', 'https://flagcdn.com/cz.svg', 1, 1),

-- Groupe B
('Canada', 'CAN', 'https://flagcdn.com/ca.svg', 2, 5),
('Suisse', 'CHE', 'https://flagcdn.com/ch.svg', 2, 1),
('Qatar', 'QAT', 'https://flagcdn.com/qa.svg', 2, 4),
('Bosnie-Herzégovine', 'BIH', 'https://flagcdn.com/ba.svg', 2, 1),

-- Groupe C
('Brésil', 'BRA', 'https://flagcdn.com/br.svg', 3, 2),
('Maroc', 'MAR', 'https://flagcdn.com/ma.svg', 3, 3),
('Haïti', 'HTI', 'https://flagcdn.com/ht.svg', 3, 5),
('Écosse', 'SCO', 'https://flagcdn.com/gb-sct.svg', 3, 1),

-- Groupe D
('États-Unis', 'USA', 'https://flagcdn.com/us.svg', 4, 5),
('Paraguay', 'PRY', 'https://flagcdn.com/py.svg', 4, 2),
('Australie', 'AUS', 'https://flagcdn.com/au.svg', 4, 6),
('Turquie', 'TUR', 'https://flagcdn.com/tr.svg', 4, 1),

-- Groupe E
('Allemagne', 'DEU', 'https://flagcdn.com/de.svg', 5, 1),
('Curaçao', 'CUW', 'https://flagcdn.com/cw.svg', 5, 5),
('Côte d\'Ivoire', 'CIV', 'https://flagcdn.com/ci.svg', 5, 3),
('Équateur', 'ECU', 'https://flagcdn.com/ec.svg', 5, 2),

-- Groupe F
('Pays-Bas', 'NLD', 'https://flagcdn.com/nl.svg', 6, 1),
('Japon', 'JPN', 'https://flagcdn.com/jp.svg', 6, 4),
('Tunisie', 'TUN', 'https://flagcdn.com/tn.svg', 6, 3),
('Suède', 'SWE', 'https://flagcdn.com/se.svg', 6, 1),

-- Groupe G
('Belgique', 'BEL', 'https://flagcdn.com/be.svg', 7, 1),
('Égypte', 'EGY', 'https://flagcdn.com/eg.svg', 7, 3),
('Iran', 'IRN', 'https://flagcdn.com/ir.svg', 7, 4),
('Nouvelle-Zélande', 'NZL', 'https://flagcdn.com/nz.svg', 7, 6),

-- Groupe H
('Espagne', 'ESP', 'https://flagcdn.com/es.svg', 8, 1),
('Cap-Vert', 'CPV', 'https://flagcdn.com/cv.svg', 8, 3),
('Arabie Saoudite', 'SAU', 'https://flagcdn.com/sa.svg', 8, 4),
('Uruguay', 'URY', 'https://flagcdn.com/uy.svg', 8, 2),

-- Groupe I
('France', 'FRA', 'https://flagcdn.com/fr.svg', 9, 1),
('Sénégal', 'SEN', 'https://flagcdn.com/sn.svg', 9, 3),
('Norvège', 'NOR', 'https://flagcdn.com/no.svg', 9, 1),
('Irak', 'IRQ', 'https://flagcdn.com/iq.svg', 9, 4),

-- Groupe J
('Argentine', 'ARG', 'https://flagcdn.com/ar.svg', 10, 2),
('Algérie', 'DZA', 'https://flagcdn.com/dz.svg', 10, 3),
('Autriche', 'AUT', 'https://flagcdn.com/at.svg', 10, 1),
('Jordanie', 'JOR', 'https://flagcdn.com/jo.svg', 10, 4),

-- Groupe K
('Portugal', 'PRT', 'https://flagcdn.com/pt.svg', 11, 1),
('Colombie', 'COL', 'https://flagcdn.com/co.svg', 11, 2),
('Ouzbékistan', 'UZB', 'https://flagcdn.com/uz.svg', 11, 4),
('RD Congo', 'COD', 'https://flagcdn.com/cd.svg', 11, 3),

-- Groupe L
('Angleterre', 'ENG', 'https://flagcdn.com/gb-eng.svg', 12, 1),
('Croatie', 'HRV', 'https://flagcdn.com/hr.svg', 12, 1),
('Ghana', 'GHA', 'https://flagcdn.com/gh.svg', 12, 3),
('Panama', 'PAN', 'https://flagcdn.com/pa.svg', 12, 5);

-- ============================================
-- JOUEURS (5 par équipe minimum)
-- ============================================

-- Groupe A - Mexique (equipe_id=1)
INSERT INTO joueurs (nom, prenom, poste, numero, equipe_id) VALUES
('Ochoa', 'Guillermo', 'GB', 1, 1),
('Sánchez', 'Jesús', 'DEF', 2, 1),
('Montes', 'César', 'DEF', 3, 1),
('Herrera', 'Héctor', 'MIL', 8, 1),
('Lozano', 'Hirving', 'ATT', 22, 1),
('Jiménez', 'Raúl', 'ATT', 9, 1),

-- Groupe A - Afrique du Sud (equipe_id=2)
('Williams', 'Ronwen', 'GB', 1, 2),
('Ngcobo', 'Siyanda', 'DEF', 5, 2),
('Hlanti', 'Sifiso', 'DEF', 3, 2),
('Zungu', 'Bongani', 'MIL', 6, 2),
('Maja', 'Lyle', 'ATT', 9, 2),
('Dolly', 'Keagan', 'ATT', 10, 2),

-- Groupe A - République de Corée (equipe_id=3)
('Kim', 'Seung-Gyu', 'GB', 1, 3),
('Kim', 'Min-Jae', 'DEF', 3, 3),
('Lee', 'Yong', 'DEF', 2, 3),
('Jung', 'Woo-Young', 'MIL', 6, 3),
('Lee', 'Jae-Sung', 'MIL', 10, 3),
('Son', 'Heung-Min', 'ATT', 7, 3),

-- Groupe A - République tchèque (equipe_id=4)
('Staněk', 'Jindřich', 'GB', 1, 4),
('Kúdela', 'Ondřej', 'DEF', 5, 4),
('Holeš', 'Tomáš', 'DEF', 4, 4),
('Souček', 'Tomáš', 'MIL', 8, 4),
('Barák', 'Antonín', 'MIL', 10, 4),
('Schick', 'Patrik', 'ATT', 9, 4),

-- Groupe B - Canada (equipe_id=5)
('Borjan', 'Milan', 'GB', 1, 5),
('Johnston', 'Alistair', 'DEF', 2, 5),
('Miller', 'Kamal', 'DEF', 5, 5),
('Eustaquio', 'Stephen', 'MIL', 7, 5),
('Davies', 'Alphonso', 'ATT', 19, 5),
('David', 'Jonathan', 'ATT', 9, 5),

-- Groupe B - Suisse (equipe_id=6)
('Sommer', 'Yann', 'GB', 1, 6),
('Elvedi', 'Nico', 'DEF', 5, 6),
('Akanji', 'Manuel', 'DEF', 6, 6),
('Freuler', 'Remo', 'MIL', 8, 6),
('Xhaka', 'Granit', 'MIL', 10, 6),
('Embolo', 'Breel', 'ATT', 9, 6),

-- Groupe B - Qatar (equipe_id=7)
('Al-Sheeb', 'Saad', 'GB', 1, 7),
('Salman', 'Abdelkarim', 'DEF', 13, 7),
('Hassan', 'Bassam', 'DEF', 5, 7),
('Boudiaf', 'Mohammed', 'MIL', 6, 7),
('Ali', 'Akram', 'MIL', 10, 7),
('Almoez', 'Ali', 'ATT', 19, 7),

-- Groupe B - Bosnie-Herzégovine (equipe_id=8)
('Sehic', 'Kenan', 'GB', 1, 8),
('Kolasinac', 'Sead', 'DEF', 5, 8),
('Bicakcic', 'Ervin', 'DEF', 4, 8),
('Pjanic', 'Miralem', 'MIL', 8, 8),
('Krunic', 'Rade', 'MIL', 7, 8),
('Dzeko', 'Edin', 'ATT', 9, 8),

-- Groupe C - Brésil (equipe_id=9)
('Alisson', 'Becker', 'GB', 1, 9),
('Silva', 'Thiago', 'DEF', 3, 9),
('Militão', 'Éder', 'DEF', 4, 9),
('Casemiro', 'Carlos', 'MIL', 5, 9),
('Rodrygo', 'Goes', 'ATT', 11, 9),
('Vinícius', 'Júnior', 'ATT', 7, 9),

-- Groupe C - Maroc (equipe_id=10)
('Bounou', 'Yassine', 'GB', 1, 10),
('Hakimi', 'Achraf', 'DEF', 2, 10),
('Aguerd', 'Nayef', 'DEF', 5, 10),
('Amrabat', 'Sofyan', 'MIL', 4, 10),
('Ziyech', 'Hakim', 'MIL', 7, 10),
('En-Nesyri', 'Youssef', 'ATT', 9, 10),

-- Groupe C - Haïti (equipe_id=11)
('Voltaire', 'Josué', 'GB', 1, 11),
('Jérôme', 'Steeven', 'DEF', 5, 11),
('Vorbe', 'Mechack', 'DEF', 4, 11),
('Cantave', 'Wilde-Donald', 'MIL', 8, 11),
('Noel', 'Kevin', 'MIL', 6, 11),
('Nazon', 'Duckens', 'ATT', 9, 11),

-- Groupe C - Écosse (equipe_id=12)
('Gordon', 'Craig', 'GB', 1, 12),
('Ralston', 'Anthony', 'DEF', 2, 12),
('Hendry', 'Jack', 'DEF', 5, 12),
('McTominay', 'Scott', 'MIL', 8, 12),
('McGinn', 'John', 'MIL', 7, 12),
('Adams', 'Che', 'ATT', 9, 12),

-- Groupe D - États-Unis (equipe_id=13)
('Turner', 'Matt', 'GB', 1, 13),
('Dest', 'Sergiño', 'DEF', 2, 13),
('Richards', 'Chris', 'DEF', 5, 13),
('McKennie', 'Weston', 'MIL', 8, 13),
('Musah', 'Yunus', 'MIL', 6, 13),
('Pulisic', 'Christian', 'ATT', 10, 13),

-- Groupe D - Paraguay (equipe_id=14)
('Silva', 'Antony', 'GB', 1, 14),
('Balbuena', 'Fabián', 'DEF', 3, 14),
('Alderete', 'Omar', 'DEF', 5, 14),
('Cubas', 'Andrés', 'MIL', 8, 14),
('Almiron', 'Miguel', 'MIL', 10, 14),
('Sanabria', 'Antonio', 'ATT', 9, 14),

-- Groupe D - Australie (equipe_id=15)
('Ryan', 'Mathew', 'GB', 1, 15),
('Behich', 'Aziz', 'DEF', 3, 15),
('Rowles', 'Kye', 'DEF', 5, 15),
('Mooy', 'Aaron', 'MIL', 7, 15),
('Irvine', 'Jackson', 'MIL', 8, 15),
('Leckie', 'Mathew', 'ATT', 9, 15),

-- Groupe D - Turquie (equipe_id=16)
('Çakır', 'Altay', 'GB', 1, 16),
('Müldür', 'Zeki', 'DEF', 2, 16),
('Demiral', 'Merih', 'DEF', 3, 16),
('Özcan', 'Salih', 'MIL', 6, 16),
('Çalhanoğlu', 'Hakan', 'MIL', 10, 16),
('Yılmaz', 'Burak', 'ATT', 9, 16),

-- Groupe E - Allemagne (equipe_id=17)
('Neuer', 'Manuel', 'GB', 1, 17),
('Rüdiger', 'Antonio', 'DEF', 2, 17),
('Schlotterbeck', 'Nico', 'DEF', 5, 17),
('Kimmich', 'Joshua', 'MIL', 6, 17),
('Musiala', 'Jamal', 'MIL', 10, 17),
('Havertz', 'Kai', 'ATT', 7, 17),

-- Groupe E - Curaçao (equipe_id=18)
('Terminal', 'Eloy', 'GB', 1, 18),
('Francisca', 'Cuco', 'DEF', 5, 18),
('Martha', 'Riechedly', 'DEF', 4, 18),
('Fer', 'Leroy', 'MIL', 8, 18),
('Laveist', 'Gevaro', 'MIL', 7, 18),
('Daal', 'Jurickson', 'ATT', 9, 18),

-- Groupe E - Côte d'Ivoire (equipe_id=19)
('Sangaré', 'Ibrahim', 'GB', 16, 19),
('Bailly', 'Eric', 'DEF', 5, 19),
('Konan', 'Wilfried', 'DEF', 3, 19),
('Sangaré', 'Ibrahim', 'MIL', 8, 19),
('Zaha', 'Wilfried', 'ATT', 11, 19),
('Haller', 'Sébastien', 'ATT', 9, 19),

-- Groupe E - Équateur (equipe_id=20)
('Domínguez', 'Hernán', 'GB', 1, 20),
('Preciado', 'Angelo', 'DEF', 2, 20),
('Hincapié', 'Piero', 'DEF', 5, 20),
('Caicedo', 'Moisés', 'MIL', 8, 20),
('Plata', 'Gonzalo', 'ATT', 11, 20),
('Valencia', 'Enner', 'ATT', 13, 20),

-- Groupe F - Pays-Bas (equipe_id=21)
('Flekken', 'Mark', 'GB', 1, 21),
('Dumfries', 'Denzel', 'DEF', 2, 21),
('Van Dijk', 'Virgil', 'DEF', 4, 21),
('De Jong', 'Frenkie', 'MIL', 8, 21),
('Gakpo', 'Cody', 'ATT', 11, 21),
('Depay', 'Memphis', 'ATT', 10, 21),

-- Groupe F - Japon (equipe_id=22)
('Gonda', 'Shuichi', 'GB', 1, 22),
('Tomiyasu', 'Takehiro', 'DEF', 5, 22),
('Yoshida', 'Maya', 'DEF', 3, 22),
('Endo', 'Wataru', 'MIL', 6, 22),
('Kamada', 'Daichi', 'MIL', 10, 22),
('Minamino', 'Takumi', 'ATT', 9, 22),

-- Groupe F - Tunisie (equipe_id=23)
('Dahmen', 'Aymen', 'GB', 1, 23),
('Meriah', 'Montassar', 'DEF', 5, 23),
('Talbi', 'Élyes', 'DEF', 4, 23),
('Skhiri', 'Ellyes', 'MIL', 8, 23),
('Khazri', 'Wahbi', 'MIL', 10, 23),
('Jebali', 'Issam', 'ATT', 9, 23),

-- Groupe F - Suède (equipe_id=24)
('Olsen', 'Robin', 'GB', 1, 24),
('Krafth', 'Emil', 'DEF', 2, 24),
('Danielson', 'Andreas', 'DEF', 5, 24),
('Ekdal', 'Albin', 'MIL', 8, 24),
('Forsberg', 'Emil', 'MIL', 10, 24),
('Isak', 'Alexander', 'ATT', 9, 24),

-- Groupe G - Belgique (equipe_id=25)
('Casteels', 'Koen', 'GB', 1, 25),
('Castagne', 'Timothy', 'DEF', 2, 25),
('Vertonghen', 'Jan', 'DEF', 5, 25),
('Tielemans', 'Youri', 'MIL', 8, 25),
('De Bruyne', 'Kevin', 'MIL', 7, 25),
('Lukaku', 'Romelu', 'ATT', 9, 25),

-- Groupe G - Égypte (equipe_id=26)
('El-Shenawy', 'Mohamed', 'GB', 1, 26),
('Hamdi', 'Akram', 'DEF', 5, 26),
('Abdelmonem', 'Ahmed', 'DEF', 4, 26),
('Elneny', 'Mohamed', 'MIL', 8, 26),
('Trezeguet', 'Ibrahim', 'MIL', 10, 26),
('Salah', 'Mohamed', 'ATT', 11, 26),

-- Groupe G - Iran (equipe_id=27)
('Beiranvand', 'Alireza', 'GB', 1, 27),
('Mohammadi', 'Ehsan', 'DEF', 3, 27),
('Pouraliganji', 'Ramin', 'DEF', 5, 27),
('Ezatolahi', 'Saeid', 'MIL', 8, 27),
('Jahanbakhsh', 'Alireza', 'MIL', 7, 27),
('Taremi', 'Mehdi', 'ATT', 9, 27),

-- Groupe G - Nouvelle-Zélande (equipe_id=28)
('Sail', 'Oli', 'GB', 1, 28),
('Seamungal', 'Liberato', 'DEF', 5, 28),
('Hamill', 'Michael', 'DEF', 4, 28),
('McGlinchey', 'Callum', 'MIL', 8, 28),
('Waine', 'Marko', 'MIL', 7, 28),
('Wood', 'Chris', 'ATT', 9, 28),

-- Groupe H - Espagne (equipe_id=29)
('Unai', 'Simón', 'GB', 1, 29),
('Carvajal', 'Dani', 'DEF', 2, 29),
('Laporte', 'Aymeric', 'DEF', 4, 29),
('Rodri', 'Rodrigo', 'MIL', 16, 29),
('Pedri', 'González', 'MIL', 8, 29),
('Morata', 'Álvaro', 'ATT', 9, 29),

-- Groupe H - Cap-Vert (equipe_id=30)
('Vozinha', 'João', 'GB', 1, 30),
('Fali', 'Stopira', 'DEF', 5, 30),
('Varela', 'Diney', 'DEF', 4, 30),
('Lopes', 'Kenny', 'MIL', 8, 30),
('Júnior', 'Garry', 'MIL', 10, 30),
('Tavares', 'Ryan', 'ATT', 9, 30),

-- Groupe H - Arabie Saoudite (equipe_id=31)
('Al-Owais', 'Mohammed', 'GB', 1, 31),
('Al-Bulayhi', 'Ali', 'DEF', 6, 31),
('Al-Tambakti', 'Hassan', 'DEF', 5, 31),
('Al-Malki', 'Sami', 'MIL', 8, 31),
('Al-Dawsari', 'Salem', 'ATT', 10, 31),
('Al-Shehri', 'Saleh', 'ATT', 9, 31),

-- Groupe H - Uruguay (equipe_id=32)
('Rochet', 'Sergio', 'GB', 1, 32),
('Giménez', 'José María', 'DEF', 2, 32),
('Godín', 'Diego', 'DEF', 3, 32),
('Valverde', 'Federico', 'MIL', 8, 32),
('Bentancur', 'Rodrigo', 'MIL', 6, 32),
('Núñez', 'Darwin', 'ATT', 9, 32),

-- Groupe I - France (equipe_id=33)
('Maignan', 'Mike', 'GB', 16, 33),
('Pavard', 'Benjamin', 'DEF', 5, 33),
('Upamecano', 'Dayot', 'DEF', 4, 33),
('Tchouaméni', 'Aurélien', 'MIL', 8, 33),
('Griezmann', 'Antoine', 'MIL', 7, 33),
('Mbappé', 'Kylian', 'ATT', 10, 33),

-- Groupe I - Sénégal (equipe_id=34)
('Mendy', 'Édouard', 'GB', 1, 34),
('Sarr', 'Ismaïla', 'DEF', 3, 34),
('Koulibaly', 'Kalidou', 'DEF', 5, 34),
('Gueye', 'Idrissa', 'MIL', 8, 34),
('Diatta', 'Krepin', 'MIL', 10, 34),
('Mané', 'Sadio', 'ATT', 10, 34),

-- Groupe I - Norvège (equipe_id=35)
('Nyland', 'Ørjan', 'GB', 1, 35),
('Ryerson', 'Julian', 'DEF', 2, 35),
('Ajer', 'Kristoffer', 'DEF', 5, 35),
('Berg', 'Sander', 'MIL', 8, 35),
('Ødegaard', 'Martin', 'MIL', 7, 35),
('Haaland', 'Erling', 'ATT', 9, 35),

-- Groupe I - Irak (equipe_id=36)
('Doham', 'Jalal', 'GB', 1, 36),
('Karrar', 'Ali', 'DEF', 5, 36),
('Hamid', 'Rebin', 'DEF', 4, 36),
('Mukhtar', 'Saad', 'MIL', 8, 36),
('Ameen', 'Ayman', 'MIL', 10, 36),
('Mohanad', 'Ali', 'ATT', 9, 36),

-- Groupe J - Argentine (equipe_id=37)
('Martínez', 'Emiliano', 'GB', 1, 37),
('Molina', 'Nahuel', 'DEF', 26, 37),
('Romero', 'Cristian', 'DEF', 13, 37),
('De Paul', 'Rodrigo', 'MIL', 7, 37),
('Mac Allister', 'Alexis', 'MIL', 20, 37),
('Messi', 'Lionel', 'ATT', 10, 37),

-- Groupe J - Algérie (equipe_id=38)
('Mandrea', 'Alexandre', 'GB', 16, 38),
('Mandi', 'Aïssa', 'DEF', 5, 38),
('Benlamri', 'Djamel', 'DEF', 4, 38),
('Bennacer', 'Ismaël', 'MIL', 8, 38),
('Atal', 'Youcef', 'MIL', 7, 38),
('Mahrez', 'Riyad', 'ATT', 11, 38),

-- Groupe J - Autriche (equipe_id=39)
('Pentz', 'Patrick', 'GB', 1, 39),
('Posch', 'Stefan', 'DEF', 5, 39),
('Hinteregger', 'Martin', 'DEF', 4, 39),
('Seiwald', 'Nicolas', 'MIL', 8, 39),
('Sabitzer', 'Marcel', 'MIL', 7, 39),
('Arnautovic', 'Marko', 'ATT', 9, 39),

-- Groupe J - Jordanie (equipe_id=40)
('Shafi', 'Yazeed', 'GB', 1, 40),
('Al-Bawab', 'Badr', 'DEF', 5, 40),
('Sukar', 'Abdallah', 'DEF', 4, 40),
('Al-Rawabdeh', 'Musa', 'MIL', 8, 40),
('Bani Attiyeh', 'Yazan', 'MIL', 7, 40),
('Al-Taamari', 'Musa', 'ATT', 10, 40),

-- Groupe K - Portugal (equipe_id=41)
('Costa', 'Diogo', 'GB', 1, 41),
('Cancelo', 'João', 'DEF', 20, 41),
('Dias', 'Rúben', 'DEF', 4, 41),
('Palhinha', 'João', 'MIL', 8, 41),
('Fernandes', 'Bruno', 'MIL', 8, 41),
('Ronaldo', 'Cristiano', 'ATT', 7, 41),

-- Groupe K - Colombie (equipe_id=42)
('Vargas', 'Camilo', 'GB', 1, 42),
('Muñoz', 'Daniel', 'DEF', 2, 42),
('Sánchez', 'Jhon', 'DEF', 5, 42),
('Lerma', 'Jefferson', 'MIL', 8, 42),
('Cuadrado', 'Juan', 'MIL', 11, 42),
('Díaz', 'Luis', 'ATT', 7, 42),

-- Groupe K - Ouzbékistan (equipe_id=43)
('Nematov', 'Otabek', 'GB', 1, 43),
('Ashurmatov', 'Khusan', 'DEF', 5, 43),
('Jaloliddinov', 'Akbar', 'DEF', 4, 43),
('Khamdamov', 'Azizbek', 'MIL', 8, 43),
('Shomurodov', 'Eldor', 'ATT', 9, 43),
('Tursunov', 'Jasur', 'ATT', 10, 43),

-- Groupe K - RD Congo (equipe_id=44)
('Kibambi', 'Ley', 'GB', 1, 44),
('Mbemba', 'Chancel', 'DEF', 5, 44),
('Batubinsika', 'Yvan', 'DEF', 4, 44),
('Tshimanga', 'Cédric', 'MIL', 8, 44),
('Kakuta', 'Gaël', 'MIL', 10, 44),
('Bakambu', 'Cédric', 'ATT', 9, 44),

-- Groupe L - Angleterre (equipe_id=45)
('Pickford', 'Jordan', 'GB', 1, 45),
('Alexander-Arnold', 'Trent', 'DEF', 66, 45),
('Maguire', 'Harry', 'DEF', 5, 45),
('Bellingham', 'Jude', 'MIL', 22, 45),
('Saka', 'Bukayo', 'ATT', 7, 45),
('Kane', 'Harry', 'ATT', 9, 45),

-- Groupe L - Croatie (equipe_id=46)
('Livakovic', 'Dominik', 'GB', 1, 46),
('Juranovic', 'Josip', 'DEF', 2, 46),
('Gvardiol', 'Joško', 'DEF', 4, 46),
('Brozovic', 'Marcelo', 'MIL', 11, 46),
('Kovacic', 'Mateo', 'MIL', 8, 46),
('Kramaric', 'Andrej', 'ATT', 9, 46),

-- Groupe L - Ghana (equipe_id=47)
('Ati-Zigi', 'Lawrence', 'GB', 1, 47),
('Lamptey', 'Tariq', 'DEF', 2, 47),
('Amartey', 'Daniel', 'DEF', 5, 47),
('Partey', 'Thomas', 'MIL', 5, 47),
('Kudus', 'Mohammed', 'MIL', 10, 47),
('Ayew', 'Jordan', 'ATT', 9, 47),

-- Groupe L - Panama (equipe_id=48)
('Mosquera', 'Orlando', 'GB', 1, 48),
('Davis', 'Fidel', 'DEF', 5, 48),
('Murillo', 'Édgar', 'DEF', 4, 48),
('Godoy', 'Adalberto', 'MIL', 8, 48),
('Cox', 'Rolando', 'MIL', 7, 48),
('Fajardo', 'Gabriel', 'ATT', 9, 48);

-- ============================================
-- UTILISATEURS
-- ============================================

-- Mot de passe pour tous : "Password123!"
-- Hash bcrypt généré avec password_hash('Password123!', PASSWORD_BCRYPT)
INSERT INTO utilisateurs (email, mot_de_passe_hash, role) VALUES
('admin@goalzone.be', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('membre1@goalzone.be', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'membre'),
('membre2@goalzone.be', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'membre');

-- ============================================
-- MATCHS (30 minimum : groupes A-C + phase finale)
-- ============================================

INSERT INTO matchs (equipe_dom_id, equipe_ext_id, stade_id, date_match, score_dom, score_ext, phase, apercu_genere) VALUES

-- Groupe A
(1, 2, 14, '2026-06-11 21:00:00', NULL, NULL, 'groupes', 0),  -- Mexique vs Afrique du Sud (match ouverture)
(3, 4, 1, '2026-06-11 18:00:00', NULL, NULL, 'groupes', 0),   -- Corée du Sud vs Rép. Tchèque
(1, 3, 14, '2026-06-18 21:00:00', NULL, NULL, 'groupes', 0),  -- Mexique vs Corée du Sud
(2, 4, 4, '2026-06-18 18:00:00', NULL, NULL, 'groupes', 0),   -- Afrique du Sud vs Rép. Tchèque
(1, 4, 14, '2026-06-25 21:00:00', NULL, NULL, 'groupes', 0),  -- Mexique vs Rép. Tchèque
(2, 3, 6, '2026-06-25 21:00:00', NULL, NULL, 'groupes', 0),   -- Afrique du Sud vs Corée du Sud

-- Groupe B
(5, 8, 11, '2026-06-12 18:00:00', NULL, NULL, 'groupes', 0),  -- Canada vs Bosnie
(6, 7, 3, '2026-06-12 21:00:00', NULL, NULL, 'groupes', 0),   -- Suisse vs Qatar
(5, 7, 11, '2026-06-19 18:00:00', NULL, NULL, 'groupes', 0),  -- Canada vs Qatar
(6, 8, 9, '2026-06-19 21:00:00', NULL, NULL, 'groupes', 0),   -- Suisse vs Bosnie
(5, 6, 12, '2026-06-24 21:00:00', NULL, NULL, 'groupes', 0),  -- Canada vs Suisse
(7, 8, 2, '2026-06-24 21:00:00', NULL, NULL, 'groupes', 0),   -- Qatar vs Bosnie

-- Groupe C
(9, 10, 1, '2026-06-14 21:00:00', NULL, NULL, 'groupes', 0),  -- Brésil vs Maroc
(11, 12, 5, '2026-06-14 18:00:00', NULL, NULL, 'groupes', 0), -- Haïti vs Écosse
(9, 11, 2, '2026-06-20 18:00:00', NULL, NULL, 'groupes', 0),  -- Brésil vs Haïti
(10, 12, 6, '2026-06-20 21:00:00', NULL, NULL, 'groupes', 0), -- Maroc vs Écosse
(9, 12, 1, '2026-06-25 18:00:00', NULL, NULL, 'groupes', 0),  -- Brésil vs Écosse
(10, 11, 4, '2026-06-25 18:00:00', NULL, NULL, 'groupes', 0), -- Maroc vs Haïti

-- Quelques matchs avec scores (simulés pour le seed)
-- Groupe A joué en avance pour demo
-- (on laisse NULL pour que la démo soit réaliste au 11 juin)

-- Phase finale (exemples)
(29, 37, 1, '2026-07-14 21:00:00', NULL, NULL, 'demi', 0),    -- Espagne vs Argentine
(33, 45, 1, '2026-07-15 21:00:00', NULL, NULL, 'demi', 0),    -- France vs Angleterre
(37, 33, 1, '2026-07-19 21:00:00', NULL, NULL, 'finale', 0),  -- Argentine vs France (finale)
(29, 45, 2, '2026-07-18 18:00:00', NULL, NULL, 'finale_petite', 0); -- Espagne vs Angleterre

-- ============================================
-- FAVORIS
-- ============================================

-- utilisateur_id 2 (membre1) aime France, Belgique, Argentine
INSERT INTO favoris (utilisateur_id, equipe_id) VALUES
(2, 33),  -- France
(2, 25),  -- Belgique
(2, 37),  -- Argentine

-- utilisateur_id 3 (membre2) aime Brésil et Maroc
(3, 9),   -- Brésil
(3, 10);  -- Maroc

-- ============================================
-- MESSAGES CONTACT
-- ============================================

INSERT INTO messages_contact (nom, email, sujet, message, lu) VALUES
('Jean Dupont', 'jean.dupont@gmail.com', 'signaler_erreur', 'Le score du match Mexique vs Afrique du Sud semble incorrect sur la page détail.', 1),
('Marie Martin', 'marie.martin@outlook.com', 'suggestion', 'Serait-il possible d\'ajouter les statistiques de possession de balle dans les aperçus IA ?', 0),
('Pierre Bernard', 'pierre.bernard@yahoo.fr', 'autre', 'Super site, j\'adore le design et les aperçus tactiques générés par IA. Continuez comme ça !', 0);