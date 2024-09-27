CREATE DATABASE score_management;

USE score_management;

-- Matches Table
CREATE TABLE matches (
    match_id INT AUTO_INCREMENT PRIMARY KEY,
    tournament_id INT NOT NULL,
    match_name VARCHAR(255) NOT NULL,
    match_date DATETIME NOT NULL,
    location VARCHAR(255),
    status ENUM('scheduled', 'completed', 'canceled') DEFAULT 'scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create the match_rules table
CREATE TABLE IF NOT EXISTS match_rules (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    tournament_id INT NOT NULL, 
    rule_description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(tournament_id)
);

-- Create the over_rules table
CREATE TABLE IF NOT EXISTS over_rules (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    tournament_id INT NOT NULL, 
    over_number INT NOT NULL, 
    rule_description TEXT NOT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(tournament_id)
);

-- Create the ball_rules table
CREATE TABLE IF NOT EXISTS ball_rules (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    tournament_id INT NOT NULL, 
    over_number INT NOT NULL, 
    ball_number INT NOT NULL, 
    rule_description TEXT NOT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(tournament_id)
);


-- Teams Table
CREATE TABLE Teams (
    team_id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(255) NOT NULL,
    coach_name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Players Table
CREATE TABLE Players (
    player_id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT,
    player_name VARCHAR(255) NOT NULL,
    position VARCHAR(50),
    jersey_number INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (team_id) REFERENCES Teams(team_id) ON DELETE CASCADE
);

-- MatchTeams Table
CREATE TABLE MatchTeams (
    match_team_id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT,
    team_id INT,
    FOREIGN KEY (match_id) REFERENCES Matches(match_id) ON DELETE CASCADE,
    FOREIGN KEY (team_id) REFERENCES Teams(team_id) ON DELETE CASCADE
);

-- MatchPlayers Table
CREATE TABLE MatchPlayers (
    match_player_id INT AUTO_INCREMENT PRIMARY KEY,
    match_team_id INT,
    player_id INT,
    FOREIGN KEY (match_team_id) REFERENCES MatchTeams(match_team_id) ON DELETE CASCADE,
    FOREIGN KEY (player_id) REFERENCES Players(player_id) ON DELETE CASCADE
);

-- Scores Table
CREATE TABLE Scores (
    score_id INT AUTO_INCREMENT PRIMARY KEY,
    match_player_id INT,
    score_value INT NOT NULL,
    score_time DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (match_player_id) REFERENCES MatchPlayers(match_player_id) ON DELETE CASCADE
);



----------------------------------------





CREATE DATABASE IF NOT EXISTS score;

USE score;

-- Matches Table
CREATE TABLE IF NOT EXISTS Matches (
    match_id INT AUTO_INCREMENT PRIMARY KEY,
    match_name VARCHAR(255) NOT NULL,
    match_date DATETIME NOT NULL,
    location VARCHAR(255),
    status ENUM('scheduled', 'completed', 'canceled') DEFAULT 'scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Teams Table
CREATE TABLE IF NOT EXISTS Teams (
    team_id INT AUTO_INCREMENT PRIMARY KEY,
    player_id INT ,
    team_name VARCHAR(255) NOT NULL,
    coach_name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Players Table
CREATE TABLE IF NOT EXISTS Players (
    player_id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT,
    player_name VARCHAR(255) NOT NULL,
    position VARCHAR(50),
    jersey_number INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (team_id) REFERENCES Teams(team_id) ON DELETE CASCADE
);

-- MatchTeams Table
CREATE TABLE IF NOT EXISTS MatchTeams (
    match_team_id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT,
    team_id INT,
    FOREIGN KEY (match_id) REFERENCES Matches(match_id) ON DELETE CASCADE,
    FOREIGN KEY (team_id) REFERENCES Teams(team_id) ON DELETE CASCADE
);

-- MatchPlayers Table
CREATE TABLE IF NOT EXISTS MatchPlayers (
    match_player_id INT AUTO_INCREMENT PRIMARY KEY,
    match_team_id INT,
    player_id INT,
    FOREIGN KEY (match_team_id) REFERENCES MatchTeams(match_team_id) ON DELETE CASCADE,
    FOREIGN KEY (player_id) REFERENCES Players(player_id) ON DELETE CASCADE
);

-- Scores Table
CREATE TABLE IF NOT EXISTS Scores (
    score_id INT AUTO_INCREMENT PRIMARY KEY,
    match_player_id INT,
    score_value INT NOT NULL,
    score_time DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (match_player_id) REFERENCES MatchPlayers(match_player_id) ON DELETE CASCADE
);

-- MatchScores Table
CREATE TABLE IF NOT EXISTS MatchScores (
    match_score_id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT,
    team_id INT,
    player_id INT,
    runs INT DEFAULT 0,
    balls_faced INT DEFAULT 0,
    wickets_taken INT DEFAULT 0,
    overs_bowled DECIMAL(4, 1) DEFAULT 0.0,
    FOREIGN KEY (match_id) REFERENCES Matches(match_id) ON DELETE CASCADE,
    FOREIGN KEY (team_id) REFERENCES Teams(team_id) ON DELETE CASCADE,
    FOREIGN KEY (player_id) REFERENCES Players(player_id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
