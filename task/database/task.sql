CREATE TABLE `tasks` (
    `id`    INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `type`  CHAR(16) NOT NULL DEFAULT 'task',
    `labels`    CHAR(255) DEFAULT NULL,
    `description`   CHAR(2048) DEFAULT '',
    `start_date`    CHAR(255) DEFAULT CURRENT_TIMESTAMP,
    `end_date`  CHAR(255) DEFAULT NULL,
    `duration`  INT DEFAULT 0,
    `order` INT DEFAULT 0,
    `progress`  INT DEFAULT 0,
    `sortorder` INT DEFAULT 0,
    `parent`    INT DEFAULT 0,
    `sprint`    CHAR(2048) DEFAULT '',
    `status`    INT DEFAULT 0,
    `priority`  INT DEFAULT 0,
    `resolution`    INT DEFAULT 0,
    `open`  int(1) DEFAULT 1,
    `buffer`    INT DEFAULT 0
);

CREATE TABLE `notes` (
    `id`    INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `labels`    CHAR(255) DEFAULT NULL,
    `description`   CHAR(2048) DEFAULT '',
    `create_date`  CHAR(11) DEFAULT CURRENT_TIMESTAMP,
    `tags`    CHAR(2048) DEFAULT '',
    `open`  int(1) DEFAULT 1
);


------------------------------------------