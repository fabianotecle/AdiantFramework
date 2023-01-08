CREATE TABLE system_group (
    id INTEGER PRIMARY KEY NOT NULL,
    name varchar(100));

CREATE TABLE system_program (
    id INTEGER PRIMARY KEY NOT NULL,
    name varchar(100),
    controller varchar(100));

CREATE TABLE system_unit (
    id INTEGER PRIMARY KEY NOT NULL,
    name varchar(100),
    connection_name varchar(100));

CREATE TABLE system_preference (
    id text,
    value text
);

CREATE TABLE system_user (
    id INTEGER PRIMARY KEY NOT NULL,
    name varchar(100),
    login varchar(100),
    password varchar(100),
    email varchar(100),
    accepted_term_policy char(1),
    phone TEXT,
    address TEXT,
    function_name TEXT,
    about TEXT,
    accepted_term_policy_at TEXT,
    accepted_term_policy_data TEXT,
    frontpage_id int, system_unit_id int references system_unit(id), active char(1),
    FOREIGN KEY(frontpage_id) REFERENCES system_program(id));
    
CREATE TABLE system_user_unit (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    system_unit_id int,
    FOREIGN KEY(system_user_id) REFERENCES system_user(id),
    FOREIGN KEY(system_unit_id) REFERENCES system_unit(id));

CREATE TABLE system_user_group (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    system_group_id int,
    FOREIGN KEY(system_user_id) REFERENCES system_user(id),
    FOREIGN KEY(system_group_id) REFERENCES system_group(id));
    
CREATE TABLE system_group_program (
    id INTEGER PRIMARY KEY NOT NULL,
    system_group_id int,
    system_program_id int,
    FOREIGN KEY(system_group_id) REFERENCES system_group(id),
    FOREIGN KEY(system_program_id) REFERENCES system_program(id));
    
CREATE TABLE system_user_program (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    system_program_id int,
    FOREIGN KEY(system_user_id) REFERENCES system_user(id),
    FOREIGN KEY(system_program_id) REFERENCES system_program(id));
        
CREATE TABLE system_user_old_password (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    password TEXT,
    created_at timestamp,
    FOREIGN KEY(system_user_id) REFERENCES system_user(id));

INSERT INTO system_group VALUES(1,'Admin');
INSERT INTO system_group VALUES(2,'Standard');

INSERT INTO system_program VALUES(1,'System Group Form','SystemGroupForm');
INSERT INTO system_program VALUES(2,'System Group List','SystemGroupList');
INSERT INTO system_program VALUES(3,'System Program Form','SystemProgramForm');
INSERT INTO system_program VALUES(4,'System Program List','SystemProgramList');
INSERT INTO system_program VALUES(5,'System User Form','SystemUserForm');
INSERT INTO system_program VALUES(6,'System User List','SystemUserList');
INSERT INTO system_program VALUES(7,'Common Page','CommonPage');
INSERT INTO system_program VALUES(8,'System PHP Info','SystemPHPInfoView');
INSERT INTO system_program VALUES(9,'System ChangeLog View','SystemChangeLogView');
INSERT INTO system_program VALUES(10,'Welcome View','WelcomeView');
INSERT INTO system_program VALUES(11,'System Sql Log','SystemSqlLogList');
INSERT INTO system_program VALUES(12,'System Profile View','SystemProfileView');
INSERT INTO system_program VALUES(13,'System Profile Form','SystemProfileForm');
INSERT INTO system_program VALUES(14,'System SQL Panel','SystemSQLPanel');
INSERT INTO system_program VALUES(15,'System Access Log','SystemAccessLogList');
INSERT INTO system_program VALUES(16,'System Message Form','SystemMessageForm');
INSERT INTO system_program VALUES(17,'System Message List','SystemMessageList');
INSERT INTO system_program VALUES(18,'System Message Form View','SystemMessageFormView');
INSERT INTO system_program VALUES(19,'System Notification List','SystemNotificationList');
INSERT INTO system_program VALUES(20,'System Notification Form View','SystemNotificationFormView');
INSERT INTO system_program VALUES(21,'System Document Category List','SystemDocumentCategoryFormList');
INSERT INTO system_program VALUES(26,'System Unit Form','SystemUnitForm');
INSERT INTO system_program VALUES(27,'System Unit List','SystemUnitList');
INSERT INTO system_program VALUES(28,'System Access stats','SystemAccessLogStats');
INSERT INTO system_program VALUES(29,'System Preference form','SystemPreferenceForm');
INSERT INTO system_program VALUES(30,'System Support form','SystemSupportForm');
INSERT INTO system_program VALUES(31,'System PHP Error','SystemPHPErrorLogView');
INSERT INTO system_program VALUES(32,'System Database Browser','SystemDatabaseExplorer');
INSERT INTO system_program VALUES(33,'System Table List','SystemTableList');
INSERT INTO system_program VALUES(34,'System Data Browser','SystemDataBrowser');
INSERT INTO system_program VALUES(35,'System Menu Editor','SystemMenuEditor');
INSERT INTO system_program VALUES(36,'System Request Log','SystemRequestLogList');
INSERT INTO system_program VALUES(37,'System Request Log View','SystemRequestLogView');
INSERT INTO system_program VALUES(38,'System Administration Dashboard','SystemAdministrationDashboard');
INSERT INTO system_program VALUES(39,'System Log Dashboard','SystemLogDashboard');
INSERT INTO system_program VALUES(40,'System Session dump','SystemSessionDumpView');
INSERT INTO system_program VALUES(41,'System Information','SystemInformationView');
INSERT INTO system_program VALUES(42,'System files diff','SystemFilesDiff');
INSERT INTO system_program VALUES(43,'System Documents','SystemDriveList');
INSERT INTO system_program VALUES(44,'System Folder form','SystemFolderForm');
INSERT INTO system_program VALUES(45,'System Share folder','SystemFolderShareForm');
INSERT INTO system_program VALUES(46,'System Share document','SystemDocumentShareForm');
INSERT INTO system_program VALUES(47,'System Document properties','SystemDocumentFormWindow');
INSERT INTO system_program VALUES(48,'System Folder properties','SystemFolderFormView');
INSERT INTO system_program VALUES(49,'System Document upload','SystemDriveDocumentUploadForm');
INSERT INTO system_program VALUES(52,'System Post list', 'SystemPostList');
INSERT INTO system_program VALUES(53,'System Post form', 'SystemPostForm');
INSERT INTO system_program VALUES(54,'Post View list', 'SystemPostFeedView');
INSERT INTO system_program VALUES(55,'Post Comment form', 'SystemPostCommentForm');
INSERT INTO system_program VALUES(56,'Post Comment list', 'SystemPostCommentList');
INSERT INTO system_program VALUES(57,'System Contacts list', 'SystemContactsList');
INSERT INTO system_program VALUES(58,'System Wiki list', 'SystemWikiList');
INSERT INTO system_program VALUES(59,'System Wiki form', 'SystemWikiForm');
INSERT INTO system_program VALUES(60,'System Wiki search', 'SystemWikiSearchList');
INSERT INTO system_program VALUES(61,'System Wiki view', 'SystemWikiView');

INSERT INTO system_user VALUES(1,'Administrator','admin','21232f297a57a5a743894a0e4a801fc3','admin@admin.net','Y','+123 456 789','Admin Street, 123','Administrator','I''m the administrator',NULL,NULL,10,NULL,'Y');
INSERT INTO system_user VALUES(2,'User','user','ee11cbb19052e40b07aac0ca060c23ee','user@user.net','Y','+123 456 789','User Street, 123','End user','I''m the end user',NULL,NULL,7,NULL,'Y');

INSERT INTO system_unit VALUES(1,'Unit A','unit_a');
INSERT INTO system_unit VALUES(2,'Unit B','unit_b');

INSERT INTO system_user_group VALUES(1,1,1);
INSERT INTO system_user_group VALUES(2,2,2);
INSERT INTO system_user_group VALUES(3,1,2);

INSERT INTO system_user_unit VALUES(1,1,1);
INSERT INTO system_user_unit VALUES(2,1,2);
INSERT INTO system_user_unit VALUES(3,2,1);
INSERT INTO system_user_unit VALUES(4,2,2);

INSERT INTO system_group_program VALUES(1,1,1);
INSERT INTO system_group_program VALUES(2,1,2);
INSERT INTO system_group_program VALUES(3,1,3);
INSERT INTO system_group_program VALUES(4,1,4);
INSERT INTO system_group_program VALUES(5,1,5);
INSERT INTO system_group_program VALUES(6,1,6);
INSERT INTO system_group_program VALUES(7,1,8);
INSERT INTO system_group_program VALUES(8,1,9);
INSERT INTO system_group_program VALUES(9,1,11);
INSERT INTO system_group_program VALUES(10,1,14);
INSERT INTO system_group_program VALUES(11,1,15);
INSERT INTO system_group_program VALUES(12,2,10);
INSERT INTO system_group_program VALUES(13,2,12);
INSERT INTO system_group_program VALUES(14,2,13);
INSERT INTO system_group_program VALUES(15,2,16);
INSERT INTO system_group_program VALUES(16,2,17);
INSERT INTO system_group_program VALUES(17,2,18);
INSERT INTO system_group_program VALUES(18,2,19);
INSERT INTO system_group_program VALUES(19,2,20);
INSERT INTO system_group_program VALUES(20,1,21);
INSERT INTO system_group_program VALUES(25,1,26);
INSERT INTO system_group_program VALUES(26,1,27);
INSERT INTO system_group_program VALUES(27,1,28);
INSERT INTO system_group_program VALUES(28,1,29);
INSERT INTO system_group_program VALUES(29,2,30);
INSERT INTO system_group_program VALUES(30,1,31);
INSERT INTO system_group_program VALUES(31,1,32);
INSERT INTO system_group_program VALUES(32,1,33);
INSERT INTO system_group_program VALUES(33,1,34);
INSERT INTO system_group_program VALUES(34,1,35);
INSERT INTO system_group_program VALUES(36,1,36);
INSERT INTO system_group_program VALUES(37,1,37);
INSERT INTO system_group_program VALUES(38,1,38);
INSERT INTO system_group_program VALUES(39,1,39);
INSERT INTO system_group_program VALUES(40,1,40);
INSERT INTO system_group_program VALUES(41,1,41);
INSERT INTO system_group_program VALUES(42,1,42);
INSERT INTO system_group_program VALUES(43,1,43);
INSERT INTO system_group_program VALUES(44,1,44);
INSERT INTO system_group_program VALUES(45,1,45);
INSERT INTO system_group_program VALUES(46,1,46);
INSERT INTO system_group_program VALUES(47,1,47);
INSERT INTO system_group_program VALUES(48,1,48);
INSERT INTO system_group_program VALUES(49,1,49);
INSERT INTO system_group_program VALUES(52,1,52);
INSERT INTO system_group_program VALUES(53,1,53);
INSERT INTO system_group_program VALUES(54,1,54);
INSERT INTO system_group_program VALUES(55,1,55);
INSERT INTO system_group_program VALUES(56,1,56);
INSERT INTO system_group_program VALUES(57,1,57);
INSERT INTO system_group_program VALUES(58,1,58);
INSERT INTO system_group_program VALUES(59,1,59);
INSERT INTO system_group_program VALUES(60,1,60);
INSERT INTO system_group_program VALUES(61,1,61);

INSERT INTO system_group_program VALUES(62,2,54);
INSERT INTO system_group_program VALUES(63,2,60);

INSERT INTO system_group_program VALUES(64,2,43);
INSERT INTO system_group_program VALUES(65,2,44);
INSERT INTO system_group_program VALUES(66,2,45);
INSERT INTO system_group_program VALUES(67,2,46);
INSERT INTO system_group_program VALUES(68,2,47);
INSERT INTO system_group_program VALUES(69,2,48);
INSERT INTO system_group_program VALUES(70,2,49);
INSERT INTO system_group_program VALUES(71,2,55);
INSERT INTO system_group_program VALUES(72,2,56);
INSERT INTO system_group_program VALUES(73,2,61);

INSERT INTO system_user_program VALUES(1,2,7);

CREATE INDEX sys_user_program_idx ON system_user(frontpage_id);
CREATE INDEX sys_user_group_group_idx ON system_user_group(system_group_id);
CREATE INDEX sys_user_group_user_idx ON system_user_group(system_user_id);
CREATE INDEX sys_group_program_program_idx ON system_group_program(system_program_id);
CREATE INDEX sys_group_program_group_idx ON system_group_program(system_group_id);
CREATE INDEX sys_user_program_program_idx ON system_user_program(system_program_id);
CREATE INDEX sys_user_program_user_idx ON system_user_program(system_user_id);


CREATE TABLE system_message
(
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id INT,
    system_user_to_id INT,
    subject TEXT,
    message TEXT,
    dt_message TEXT,
    checked char(1)
);

CREATE TABLE system_notification
(
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id INT,
    system_user_to_id INT,
    subject TEXT,
    message TEXT,
    dt_message TEXT,
    action_url TEXT,
    action_label TEXT,
    icon TEXT,
    checked char(1)
);

CREATE TABLE system_document_category
(
    id INTEGER PRIMARY KEY NOT NULL,
    name TEXT
);
INSERT INTO system_document_category VALUES(1,'Documentação');

CREATE TABLE system_folder (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    created_at date,
    name text not null,
    in_trash char(1),
    system_folder_parent_id int REFERENCES system_folder (id)
);

CREATE TABLE system_folder_user
(
    id INTEGER PRIMARY KEY NOT NULL,
    system_folder_id INTEGER references system_folder(id),
    system_user_id INTEGER
);

CREATE TABLE system_folder_group
(
    id INTEGER PRIMARY KEY NOT NULL,
    system_folder_id INTEGER references system_folder(id),
    system_group_id INTEGER
);

CREATE TABLE system_document
(
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id INTEGER,
    title TEXT,
    description TEXT,
    category_id INTEGER references system_document_category(id),
    submission_date DATE,
    archive_date DATE,
    filename TEXT,
    in_trash char(1),
    system_folder_id INTEGER references system_folder(id)
);

CREATE TABLE system_document_user
(
    id INTEGER PRIMARY KEY NOT NULL,
    document_id INTEGER references system_document(id),
    system_user_id INTEGER
);

CREATE TABLE system_document_group
(
    id INTEGER PRIMARY KEY NOT NULL,
    document_id INTEGER references system_document(id),
    system_group_id INTEGER
);

CREATE TABLE system_document_bookmark (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    system_document_id INTEGER references system_document(id)
);

CREATE TABLE system_folder_bookmark (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    system_folder_id INTEGER references system_folder(id)
);

CREATE TABLE system_post (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    title TEXT not NULL,
    content TEXT not NULL,
    created_at timestamp not null,
    active char(1) default 'Y' not null
);

CREATE TABLE system_post_share_group (
    id INTEGER PRIMARY KEY NOT NULL,
    system_group_id int,
    system_post_id int REFERENCES system_post (id)
);

CREATE TABLE system_post_tag (
    id INTEGER PRIMARY KEY NOT NULL,
    system_post_id int REFERENCES system_post (id),
    tag text not null
);

CREATE TABLE system_post_comment (
    id INTEGER PRIMARY KEY NOT NULL,
    comment TEXT not NULL,
    system_user_id int not null,
    system_post_id int REFERENCES system_post (id),
    created_at timestamp not null
);

CREATE TABLE system_post_like (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    system_post_id int REFERENCES system_post (id),
    created_at timestamp not null
);

CREATE TABLE system_wiki_page (
    id INTEGER PRIMARY KEY NOT NULL,
    system_user_id int,
    created_at timestamp not null,
    updated_at timestamp,
    title TEXT not null,
    description TEXT not null,
    content TEXT not null,
    active char(1) default 'Y' not null,
    searchable char(1) default 'Y' not null
);

CREATE TABLE system_wiki_tag (
    id INTEGER PRIMARY KEY NOT NULL,
    system_wiki_page_id int REFERENCES system_wiki_page (id),
    tag text not null
);

CREATE TABLE system_wiki_share_group (
    id INTEGER PRIMARY KEY NOT NULL,
    system_group_id int,
    system_wiki_page_id int REFERENCES system_wiki_page (id)
);

INSERT INTO system_post VALUES(1,1,'Primeira notícia','<p style="text-align: justify; "><span style="font-family: &quot;Source Sans Pro&quot;; font-size: 18px;">﻿</span><span style="font-family: &quot;Source Sans Pro&quot;; font-size: 18px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id cursus metus aliquam eleifend mi in nulla posuere sollicitudin. Tincidunt nunc pulvinar sapien et ligula ullamcorper. Odio pellentesque diam volutpat commodo sed egestas egestas. Eget egestas purus viverra accumsan in nisl nisi scelerisque. Habitant morbi tristique senectus et netus et malesuada. Vitae ultricies leo integer malesuada nunc vel risus commodo viverra. Vehicula ipsum a arcu cursus. Rhoncus est pellentesque elit ullamcorper dignissim. Faucibus in ornare quam viverra orci sagittis eu. Nisi scelerisque eu ultrices vitae auctor. Tellus cras adipiscing enim eu turpis egestas. Eget lorem dolor sed viverra ipsum nunc aliquet. Neque convallis a cras semper auctor neque. Bibendum ut tristique et egestas. Amet nisl suscipit adipiscing bibendum.</span></p><p style="text-align: justify;"><span style="font-family: &quot;Source Sans Pro&quot;; font-size: 18px;">Mattis nunc sed blandit libero volutpat sed cras ornare. Leo duis ut diam quam nulla. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum sociis. Non quam lacus suspendisse faucibus. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere ac. Dignissim enim sit amet venenatis urna. Elit sed vulputate mi sit. Sit amet nisl suscipit adipiscing bibendum est. Maecenas accumsan lacus vel facilisis. Orci phasellus egestas tellus rutrum tellus pellentesque eu tincidunt tortor. Aenean pharetra magna ac placerat vestibulum lectus mauris ultrices eros. Augue lacus viverra vitae congue eu consequat ac felis. Bibendum neque egestas congue quisque egestas diam. Facilisis magna etiam tempor orci eu lobortis elementum. Rhoncus est pellentesque elit ullamcorper dignissim cras tincidunt lobortis. Pellentesque adipiscing commodo elit at imperdiet dui accumsan sit amet. Nullam eget felis eget nunc. Nec ullamcorper sit amet risus nullam eget felis. Lacus vel facilisis volutpat est velit egestas dui id.</span></p>','2022-11-03 14:59:39','Y');
INSERT INTO system_post VALUES(2,1,'Segunda notícia','<p style="text-align: justify; "><span style="font-size: 18px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ac orci phasellus egestas tellus rutrum. Pretium nibh ipsum consequat nisl vel pretium lectus quam. Faucibus scelerisque eleifend donec pretium vulputate sapien. Mattis molestie a iaculis at erat pellentesque adipiscing commodo elit. Ultricies mi quis hendrerit dolor magna eget. Quam id leo in vitae turpis massa sed elementum tempus. Eget arcu dictum varius duis at consectetur lorem. Quis varius quam quisque id diam. Consequat interdum varius sit amet mattis vulputate. Purus non enim praesent elementum facilisis leo vel fringilla. Nulla facilisi nullam vehicula ipsum a arcu. Habitant morbi tristique senectus et netus et malesuada fames. Risus commodo viverra maecenas accumsan lacus. Mattis molestie a iaculis at erat pellentesque adipiscing commodo elit. Imperdiet proin fermentum leo vel orci porta non pulvinar neque. Massa massa ultricies mi quis hendrerit. Vel turpis nunc eget lorem dolor sed viverra ipsum nunc. Quisque egestas diam in arcu cursus euismod quis.</span></p><p style="text-align: justify; "><span style="font-size: 18px;">Posuere morbi leo urna molestie at elementum eu facilisis. Dolor morbi non arcu risus quis varius quam. Fermentum posuere urna nec tincidunt praesent semper feugiat nibh. Consectetur adipiscing elit ut aliquam purus sit. Gravida cum sociis natoque penatibus et magnis. Sollicitudin aliquam ultrices sagittis orci. Tortor consequat id porta nibh venenatis cras sed felis. Dictumst quisque sagittis purus sit amet volutpat consequat mauris nunc. Arcu dictum varius duis at consectetur. Mauris commodo quis imperdiet massa tincidunt nunc pulvinar. At tellus at urna condimentum mattis pellentesque. Tellus mauris a diam maecenas sed.</span></p>','2022-11-03 15:03:31','Y');

INSERT INTO system_post_share_group VALUES(1,1,1);
INSERT INTO system_post_share_group VALUES(2,2,1);
INSERT INTO system_post_share_group VALUES(3,1,2);
INSERT INTO system_post_share_group VALUES(4,2,2);

INSERT INTO system_post_tag VALUES(1,1,'novidades');
INSERT INTO system_post_tag VALUES(2,2,'novidades');

INSERT INTO system_post_comment VALUES(1,'My first comment',1,2,'2022-11-03 15:22:11');
INSERT INTO system_post_comment VALUES(2,'Another comment',1,2,'2022-11-03 15:22:17');
INSERT INTO system_post_comment VALUES(3,'The best comment',2,2,'2022-11-03 15:23:11');

INSERT INTO system_wiki_page VALUES(1,1,'2022-11-02 15:33:58','2022-11-02 15:35:10','Manual de operações','Este manual explica os procedimentos básicos de operação','<p style="text-align: justify; "><span style="font-size: 18px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sapien nec sagittis aliquam malesuada bibendum arcu vitae. Quisque egestas diam in arcu cursus euismod quis. Risus nec feugiat in fermentum posuere urna nec tincidunt praesent. At imperdiet dui accumsan sit amet. Est pellentesque elit ullamcorper dignissim cras tincidunt lobortis. Elementum facilisis leo vel fringilla est ullamcorper. Id porta nibh venenatis cras. Viverra orci sagittis eu volutpat odio facilisis mauris sit. Senectus et netus et malesuada fames ac turpis. Sociis natoque penatibus et magnis dis parturient montes. Vel turpis nunc eget lorem dolor sed viverra ipsum nunc. Sed viverra tellus in hac habitasse. Tellus id interdum velit laoreet id donec ultrices tincidunt arcu. Pharetra et ultrices neque ornare aenean euismod elementum. Volutpat blandit aliquam etiam erat velit scelerisque in. Neque aliquam vestibulum morbi blandit cursus risus. Id consectetur purus ut faucibus pulvinar elementum.</span></p><p style="text-align: justify; "><br></p>','Y','Y');
INSERT INTO system_wiki_page VALUES(2,1,'2022-11-02 15:35:04','2022-11-02 15:37:49','Instruções de lançamento','Este manual explica as instruções de lançamento de produto','<p><span style="font-size: 18px;">Non curabitur gravida arcu ac tortor dignissim convallis. Nunc scelerisque viverra mauris in aliquam sem fringilla ut morbi. Nunc eget lorem dolor sed viverra. Et odio pellentesque diam volutpat commodo sed egestas. Enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra. Faucibus et molestie ac feugiat. Erat velit scelerisque in dictum non consectetur a erat nam. Quis risus sed vulputate odio ut enim blandit volutpat. Pharetra vel turpis nunc eget lorem dolor sed viverra. Nisl tincidunt eget nullam non nisi est sit. Orci phasellus egestas tellus rutrum tellus pellentesque eu. Et tortor at risus viverra adipiscing at in tellus integer. Risus ultricies tristique nulla aliquet enim. Ac felis donec et odio pellentesque diam volutpat commodo sed. Ut morbi tincidunt augue interdum. Morbi tempus iaculis urna id volutpat.</span></p><p><a href="index.php?class=SystemWikiView&amp;method=onLoad&amp;key=3" generator="adianti">Sub página de instruções 1</a></p><p><a href="index.php?class=SystemWikiView&amp;method=onLoad&amp;key=4" generator="adianti">Sub página de instruções 2</a><br><span style="font-size: 18px;"><br></span><br></p>','Y','Y');
INSERT INTO system_wiki_page VALUES(3,1,'2022-11-02 15:36:59','2022-11-02 15:37:21','Instruções - sub página 1','Instruções - sub página 1','<p><span style="font-size: 18px;">Follow these steps:</span></p><ol><li><span style="font-size: 18px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span></li><li><span style="font-size: 18px;">Sapien nec sagittis aliquam malesuada bibendum arcu vitae.</span></li><li><span style="font-size: 18px;">Quisque egestas diam in arcu cursus euismod quis.</span><br></li></ol>','Y','N');
INSERT INTO system_wiki_page VALUES(4,1,'2022-11-02 15:37:17','2022-11-02 15:37:22','Instruções - sub página 2','Instruções - sub página 2','<p><span style="font-size: 18px;">Follow these steps:</span></p><ol><li><span style="font-size: 18px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span></li><li><span style="font-size: 18px;">Sapien nec sagittis aliquam malesuada bibendum arcu vitae.</span></li><li><span style="font-size: 18px;">Quisque egestas diam in arcu cursus euismod quis.</span></li></ol>','Y','N');

INSERT INTO system_wiki_tag VALUES(3,1,'manual');
INSERT INTO system_wiki_tag VALUES(5,4,'manual');
INSERT INTO system_wiki_tag VALUES(6,3,'manual');
INSERT INTO system_wiki_tag VALUES(7,2,'manual');

INSERT INTO system_wiki_share_group VALUES(1,1,1);
INSERT INTO system_wiki_share_group VALUES(2,2,1);
INSERT INTO system_wiki_share_group VALUES(3,1,2);
INSERT INTO system_wiki_share_group VALUES(4,2,2);
INSERT INTO system_wiki_share_group VALUES(5,1,3);
INSERT INTO system_wiki_share_group VALUES(6,2,3);
INSERT INTO system_wiki_share_group VALUES(7,1,4);
INSERT INTO system_wiki_share_group VALUES(8,2,4);
