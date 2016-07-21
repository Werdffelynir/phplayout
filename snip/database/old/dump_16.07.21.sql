PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE "types"(
    "name" TEXT PRIMARY KEY,
    "deep" INTEGER UNIQUE NOT NULL
) WITHOUT ROWID;
INSERT INTO "types" VALUES('category',1);
INSERT INTO "types" VALUES('subcategory',2);
INSERT INTO "types" VALUES('item',3);
CREATE TABLE "item" (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`deep`	INTEGER NOT NULL DEFAULT 0,
	`link`	TEXT,
	`title`	TEXT NOT NULL,
	`content`	TEXT NOT NULL,
	`created`	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`updated`	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`keyword`	TEXT,
	`description`	TEXT,
	`tags`	INTEGER
);
INSERT INTO "item" VALUES(1,1,'php','PHP','PHP Code Snippets','01.07.2016 01:30:53','2016-07-15 22:05:45','','','');
INSERT INTO "item" VALUES(2,1,'javascript','JavaScript','JavaScript Code Snippets','01.07.2016 01:30:53','2016-07-15 22:05:45','','','');
INSERT INTO "item" VALUES(3,1,'python','Python','Python Code Snippets','01.07.2016 01:30:53','2016-07-15 22:05:45','','','');
INSERT INTO "item" VALUES(4,1,'html','HTML','html','01.07.2016 01:30:53','2016-07-15 22:05:45','','','');
INSERT INTO "item" VALUES(5,1,'css','CSS','Сегодня хотелось бы рассмотреть вопрос, который нередко встречается у пользователей – что нужно сделать, чтобы в Linux Ubuntu установить время. И первым вариантом будет ставший привычным большинству пользователей вариант работы через графический интерфейс.','09.07.2016 01:30:53','2016-07-15 22:05:45','','','');
INSERT INTO "item" VALUES(6,1,'actionscript','ActionScript','ActionScript','09.07.2016 01:31:46','2016-07-15 22:05:45','','','');
INSERT INTO "item" VALUES(7,1,'csharp','C#','csharp','09.07.2016 01:32:49','2016-07-15 22:05:45','','','');
INSERT INTO "item" VALUES(8,1,'java','Java','JavaJavaJava','09.07.2016 01:33:28','2016-07-15 22:05:45','','','');
INSERT INTO "item" VALUES(9,1,'linux','Linux','LinuxLinuxLinux','09.07.2016 01:33:50','2016-07-15 22:05:45','','','');
CREATE TABLE "relation" (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`parent`	INTEGER NOT NULL,
	`child`	INTEGER NOT NULL,
	`type`	TEXT DEFAULT NULL
);
DELETE FROM sqlite_sequence;
INSERT INTO "sqlite_sequence" VALUES('item',10);
INSERT INTO "sqlite_sequence" VALUES('relation',1);
CREATE UNIQUE INDEX unique_name on "item"(link);
COMMIT;
