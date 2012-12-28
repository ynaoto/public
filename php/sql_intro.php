<?php
  define("MIND", "mind");
  define("INPUT", "input");
  define("OUTPUT", "output");
  define("NOTE", "note");

  define("TAG", "tag");
  define("S", "s");

  $col = [
    MIND => [ TAG => "span", S => "気持ち" ],
    INPUT => [ TAG => "kbd", S => "入力" ],
    OUTPUT => [ TAG => "samp", S => "出力(雰囲気)" ],
    NOTE => [ TAG => "span", S => "摘要" ]
  ];

$item = [
[
MIND => "SQLに繋いでみたい",
INPUT =>
"cd \\xampp
dir/w
cd mysql
dir/w
cd bin
dir/w
.\\mysql.exe -u <var>root</var> -p",
OUTPUT =>
"Enter password: ******
Welcome to the MySQL monitor.  Commands end with <em>;</em> or \g.
Your MySQL connection id is <var>119</var>
Server version: 5.5.28 Source distribution

Copyright (c) 2000, 2012, Oracle and/or its affiliates. All rights reserved.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '<em>\c</em>' to clear the current input statement.

mysql> ",
NOTE => "TABを使って効率的に (root のパスワードがわからない人は先生に聞いて下さい)",
],
[
MIND => "どんなデータベースがあるだろう？",
INPUT =>
"<em>show</em> database<em>s</em>;",
OUTPUT =>
"mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| information_schema |
| cdcol              |
| mysql              |
| performance_schema |
| phpmyadmin         |
| test               |
+--------------------+
6 rows in set (0.01 sec)",
NOTE => "<q>database<em>s</em></q>が複数形であること、末尾の<q><em>;</em></q>に注意",
], [
MIND => "使う前のおまじない(Windows)。キャラクタセットの設定",
INPUT =>
"set name<em>s</em> <var>cp932</var>;",
OUTPUT =>
"mysql> set names <var>cp932</var>;
Query OK, 0 rows affected (0.00 sec)",
NOTE => "Windowsの場合、DOSプロンプトの文字コードがSJISなのでこれが必要",
],
[
MIND => "ところで「キャラクタセット」って何だっけ？",
INPUT =>
"show character set;",
OUTPUT =>
"mysql> show character set;
+----------+-----------------------------+---------------------+--------+
| Charset  | Description                 | Default collation   | Maxlen |
+----------+-----------------------------+---------------------+--------+
| big5     | Big5 Traditional Chinese    | big5_chinese_ci     |      2 |
| dec8     | DEC West European           | dec8_swedish_ci     |      1 |
| cp850    | DOS West European           | cp850_general_ci    |      1 |
| hp8      | HP West European            | hp8_english_ci      |      1 |
| koi8r    | KOI8-R Relcom Russian       | koi8r_general_ci    |      1 |
(中略)
| utf32    | UTF-32 Unicode              | utf32_general_ci    |      4 |
| binary   | Binary pseudo charset       | binary              |      1 |
| geostd8  | GEOSTD8 Georgian            | geostd8_general_ci  |      1 |
| cp932    | SJIS for Windows Japanese   | cp932_japanese_ci   |      2 |
| eucjpms  | UJIS for Windows Japanese   | eucjpms_japanese_ci |      3 |
+----------+-----------------------------+---------------------+--------+
39 rows in set (0.00 sec)",
NOTE => "Windowsの場合、DOSプロンプトの文字コードがSJISなのでこれが必要",
],
[
MIND => "なげーよ・・。絞り込む",
INPUT =>
"show character set like '<var>cp%</var>';",
OUTPUT =>
"mysql> show character set like '<var>cp%</var>';
+---------+---------------------------+-------------------+--------+
| Charset | Description               | Default collation | Maxlen |
+---------+---------------------------+-------------------+--------+
| cp850   | DOS West European         | cp850_general_ci  |      1 |
| cp1250  | Windows Central European  | cp1250_general_ci |      1 |
| cp866   | DOS Russian               | cp866_general_ci  |      1 |
| cp852   | DOS Central European      | cp852_general_ci  |      1 |
| cp1251  | Windows Cyrillic          | cp1251_general_ci |      1 |
| cp1256  | Windows Arabic            | cp1256_general_ci |      1 |
| cp1257  | Windows Baltic            | cp1257_general_ci |      1 |
| <em>cp932</em>   | <em>SJIS for Windows Japanese</em> | cp932_japanese_ci |      2 |
+---------+---------------------------+-------------------+--------+
8 rows in set (0.00 sec)",
NOTE => "<q><em>%</em></q>が「ワイルドカード」。<q>like 'utf%'</q>も試してみると面白い",
],
[
MIND => "本当にできたかな？",
INPUT =>
"show variables like '<var>char%</var>';",
OUTPUT =>
"mysql> show variables like '<var>char%</var>';
+--------------------------+------------------------------------------------------+
| Variable_name            | Value                                                |
+--------------------------+------------------------------------------------------+
| character_set_client     | cp932                                                |
| character_set_connection | cp932                                                |
| character_set_database   | utf8                                                 |
| character_set_filesystem | binary                                               |
| character_set_results    | cp932                                                |
| character_set_server     | utf8                                                 |
| character_set_system     | utf8                                                 |
| character_sets_dir       | C:\\xampp\\mysql\\share\\charsets\\                       |
+--------------------------+------------------------------------------------------+
8 rows in set (0.01 sec)",
NOTE => "Windowsの場合、このようになっていればOK。Macでは全てutf8になっているのが便利",
],
[
MIND => "「データベース」を作ってみる",
INPUT =>
"<em>create</em> database <var>foo</var>;",
OUTPUT =>
"mysql> create database <var>foo</var>;
Query OK, 1 row affected (0.01 sec)",
NOTE => "<q>Query OK</q>が成功の返事。<q><var>foo</var></q>はテキトーな名前",
],
[
MIND => "できたかな？",
INPUT =>
"show databases;",
OUTPUT =>
"mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| information_schema |
| cdcol              |
| <em><var>foo</var></em>                |
| mysql              |
| performance_schema |
| phpmyadmin         |
| test               |
+--------------------+
7 rows in set (0.01 sec)",
NOTE => "しつこいですが、<q>database<em>s</em></q>が複数形であることに注意",
],
[
MIND => "作ったデータベースを確認する",
INPUT =>
"show create database <var>foo</var>;",
OUTPUT =>
"mysql> show create database <var>foo</var>;
+----------+--------------------------------------------------------------+
| Database | Create Database                                              |
+----------+--------------------------------------------------------------+
| <var>foo</var>      | CREATE DATABASE `<var>foo</var>` /*!40100 DEFAULT CHARACTER SET utf8 */ |
+----------+--------------------------------------------------------------+
1 row in set (0.00 sec)",
NOTE => "データベースを作成した手続きが出力される。また、何も指定しない場合に使われる文字コードも確認できる。この場合<q>utf8</q>なのでOK",
],
[
MIND => "じゃあ、キャラクタセットを変えてみる",
INPUT =>
"<em>alter</em> database <var>foo</var> character set <em><var>latin1</var></em>;",
OUTPUT =>
"mysql> alter database <var>foo</var> character set <var>latin1</var>;
Query OK, 1 row affected (0.00 sec)",
NOTE => "<q><var>latin1</var></q>はアルファベットのみの文字セット",
],
[
MIND => "変更できたか確認する",
INPUT =>
"show create database <var>foo</var>;",
OUTPUT =>
"mysql> show create database <var>foo</var>;
+----------+----------------------------------------------------------------+
| Database | Create Database                                                |
+----------+----------------------------------------------------------------+
| <var>foo</var>      | CREATE DATABASE `<var>foo</var>` /*!40100 DEFAULT CHARACTER SET <em><var>latin1</var></em> */ |
+----------+----------------------------------------------------------------+
1 row in set (0.00 sec)",
NOTE => "確かに<q><var>latin1</var></q>になっている",
],
[
MIND => "元に戻す",
INPUT =>
"alter database <var>foo</var> character set <em><var>utf8</var></em>;",
OUTPUT =>
"mysql> alter database <var>foo</var> character set <var>utf8</var>;
Query OK, 1 row affected (0.00 sec)",
NOTE => "",
],
[
MIND => "戻ったか確認する",
INPUT =>
"show create database <var>foo</var>;",
OUTPUT =>
"mysql> show create database <var>foo</var>;
+----------+--------------------------------------------------------------+
| Database | Create Database                                              |
+----------+--------------------------------------------------------------+
| <var>foo</var>      | CREATE DATABASE `<var>foo</var>` /*!40100 DEFAULT CHARACTER SET <em><var>utf8</var></em> */ |
+----------+--------------------------------------------------------------+
1 row in set (0.00 sec)",
NOTE => "確かに<q><var>utf8</var></q>になっている",
],
[
MIND => "データベースの名前を変えたい",
INPUT =>
"rename database <var>foo</var> to <var>bar</var>;",
OUTPUT =>
"mysql> rename database <var>foo</var> to <var>bar</var>;
<em>ERROR</em> 1064 (42000): You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'database <var>foo</var> to <var>bar</var>' at line 1",
NOTE => "セキュリティ上の理由で、最近のMySQLでは<em>データベース名の変更をSQL文で行うことはできない</em>ようになっています。データベースを停止して、同様の操作を行うことはできますが、ややこしいので本稿では扱いません。データベース名は間違わないようにつけて下さい。WEB上には、この構文でデータベース名の変更ができるという記述も見つかりますが、古い情報ですので注意して下さい (2012/12/13現在)",
],
[
MIND => "これから使うデータベースを選択",
INPUT =>
"<em>use</em> <var>foo</var>;",
OUTPUT =>
"mysql> use <var>foo</var>;
Database changed",
NOTE => "この後、データベースにテーブルを作っていくときに、対象とするデータベースを指定します。DOSプロンプトの <q>cd <var>foo</var></q> に似ています",
],
[
MIND => "テーブルを作る",
INPUT =>
"create table <var>bar</var> (<var>id</var> <var>int</var>, <var>name</var> <var>text</var>);",
OUTPUT =>
"mysql> create table <var>bar</var> (<var>id</var> <var>int</var>, <var>name</var> <var>text</var>);
Query OK, 0 rows affected (0.28 sec)",
NOTE => "<q><var>bar</var></q>という名前で、先ほど選択したデータベース<q><var>foo</var></q>内にテーブルを作ります。<q>フィールド</q>は２つ、整数型(<var>int</var>)の<q><var>id</var></q>と、テキスト型(<var>text</var>)の<q><var>name</var></q>です",
],
[
MIND => "テーブル一覧を表示する",
INPUT =>
"show tables;",
OUTPUT =>
"mysql> show tables;
+---------------+
| Tables_in_<em><var>foo</var></em> |
+---------------+
| <em><var>bar</var></em>           |
+---------------+
1 row in set (0.00 sec)",
NOTE => "確かに、データベース<q><var>foo</var></q>にテーブル<q><var>bar</var></q>ができています",
],
[
MIND => "テーブルの設定を表示する",
INPUT =>
"show create table <var>bar</var>;",
OUTPUT =>
"mysql> show create table <var>bar</var>;
+-------+------------------------------------------------------------------------------------------------------+
| Table | Create Table                                               
                |
+-------+------------------------------------------------------------------------------------------------------+
| <var>bar</var>   | CREATE TABLE `<var>bar</var>` (
  `<var>id</var>` <var>int</var>(11) DEFAULT NULL,
  `<var>name</var>` <var>text</var>
) ENGINE=InnoDB DEFAULT CHARSET=utf8 |
+-------+------------------------------------------------------------------------------------------------------+
1 row in set (0.01 sec)",
NOTE => "表示はされるけど、横幅が長くて読み辛い！経線が邪魔！",
],
[
MIND => "テーブルの設定を別の形式で表示する",
INPUT =>
"show create table <var>bar</var><em>\G</em>",
OUTPUT =>
"mysql> show create table <var>bar</var>\G
*************************** 1. row ***************************
       Table: <var>bar</var>
Create Table: CREATE TABLE `<var>bar</var>` (
  `<var>id</var>` <var>int</var>(11) DEFAULT NULL,
  `<var>name</var>` <var>text</var>
) ENGINE=InnoDB DEFAULT CHARSET=utf8
1 row in set (0.00 sec)",
NOTE => "命令の終わりで<q>;</q>の替わりに<q><em>\G</em></q>を使うと表示形式がシンプルになる",
],
[
MIND => "テーブルの構成を表示する",
INPUT =>
"show <em>columns</em> from <var>bar</var>;",
OUTPUT =>
"mysql> show columns from <var>bar</var>;
+-------+---------+------+-----+---------+-------+
| Field | Type    | Null | Key | Default | Extra |
+-------+---------+------+-----+---------+-------+
| <var>id</var>    | <var>int</var>(11) | YES  |     | NULL    |       |
| <var>name</var>  | <var>text</var>    | YES  |     | NULL    |       |
+-------+---------+------+-----+---------+-------+
2 rows in set (0.01 sec)",
NOTE => "フィールド<q><var>id</var></q>の「型」は<q><var>int</var></q>、<q><var>name</var></q>は<q><var>text</var></q>であることがわかる。他の表示項目は今は無視していいです",
],
[
MIND => "これでもいいです",
INPUT =>
"show <em>fields</em> from <var>bar</var>;",
OUTPUT =>
"mysql> show fields from bar;
+-------+---------+------+-----+---------+-------+
| Field | Type    | Null | Key | Default | Extra |
+-------+---------+------+-----+---------+-------+
| id    | int(11) | YES  |     | NULL    |       |
| name  | text    | YES  |     | NULL    |       |
+-------+---------+------+-----+---------+-------+
2 rows in set (0.00 sec)",
NOTE => "<q>fields</q>は<q>columns</q>と同じ意味です",
],
[
MIND => "これでもいいです",
INPUT =>
"describe <var>bar</var>;",
OUTPUT =>
"mysql> describe <var>bar</var>;
+-------+---------+------+-----+---------+-------+
| Field | Type    | Null | Key | Default | Extra |
+-------+---------+------+-----+---------+-------+
| <var>id</var>    | <var>int</var>(11) | YES  |     | NULL    |       |
| <var>name</var>  | <var>text</var>    | YES  |     | NULL    |       |
+-------+---------+------+-----+---------+-------+
2 rows in set (0.01 sec)",
NOTE => "<q>describe</q>は、<q>show columns from</q>へのショートカットです",
],
[
MIND => "これが一番簡単なのでお勧めです",
INPUT =>
"<em>desc</em> <var>bar</var>;",
OUTPUT =>
"mysql> desc <var>bar</var>;
+-------+---------+------+-----+---------+-------+
| Field | Type    | Null | Key | Default | Extra |
+-------+---------+------+-----+---------+-------+
| <var>id</var>    | <var>int</var>(11) | YES  |     | NULL    |       |
| <var>name</var>  | <var>text</var>    | YES  |     | NULL    |       |
+-------+---------+------+-----+---------+-------+
2 rows in set (0.01 sec)",
NOTE => "<q>desc</q>は<q>describe</q>へのショートカットです",
],
[
MIND => "テーブル名はSQL文で変更できます",
INPUT =>
"<em>rename</em> table <var>bar</var> to <var>baz</var>;",
OUTPUT =>
"mysql> rename table <var>bar</var> to <var>baz</var>;
Query OK, 0 rows affected (0.01 sec)",
NOTE => "<q><var>baz</var></q>もテキトーな名前です",
],
[
MIND => "<q><var>baz</var></q>を確認",
INPUT =>
"desc <var>baz</var>;",
OUTPUT =>
"mysql> desc <var>baz</var>;
+-------+---------+------+-----+---------+-------+
| Field | Type    | Null | Key | Default | Extra |
+-------+---------+------+-----+---------+-------+
| <var>id</var>    | <var>int</var>(11) | YES  |     | NULL    |       |
| <var>name</var>  | <var>text</var>    | YES  |     | NULL    |       |
+-------+---------+------+-----+---------+-------+
2 rows in set (0.01 sec)",
NOTE => "名前を変えても構成は変わりません",
],
[
MIND => "テーブルの状態を見たい",
INPUT =>
"show table status;",
OUTPUT =>
"mysql> show table status;
+------+--------+---------+------------+------+----------------+-------------+-----------------+--------------+-----------+----------------+---------------------+-------------+------------+-----------------+----------+----------------+---------+
| Name | Engine | Version | Row_format | Rows | Avg_row_length | Data_length | Max_data_length | Index_length | Data_free | Auto_increment | Create_time         | Update_time | Check_time | Collation       | Checksum | Create_options | Comment |
+------+--------+---------+------------+------+----------------+-------------+-----------------+--------------+-----------+----------------+---------------------+-------------+------------+-----------------+----------+----------------+---------+
| <var>baz</var>  | InnoDB |      10 | Compact    |    0 |              0 |       16384 |               0 |            0 |   8388608 |         
(中略)
1 row in set (0.01 sec)",
NOTE => "ぐちゃぐちゃで読めません。こんなときは <q>;</q> の替わりに <q>\G</q> の出番です",
],
[
MIND => "<q>\G</q> 記法を使う",
INPUT =>
"show table status\G",
OUTPUT =>
"mysql> show table status\G
*************************** 1. row ***************************
           Name: <var>baz</var>
         Engine: InnoDB
        Version: 10
     Row_format: Compact
           <em>Rows: 0</em>
 Avg_row_length: 0
    Data_length: 16384
Max_data_length: 0
   Index_length: 0
      Data_free: 8388608
 Auto_increment: NULL
    Create_time: 2012-12-13 20:07:08
    Update_time: NULL
     Check_time: NULL
      Collation: utf8_general_ci
       Checksum: NULL
 Create_options: 
        Comment: 
1 row in set (0.00 sec)",
NOTE => "色々な情報が出ますが、<q>Rows</q>に注目。これは、テーブルに格納された情報の個数です。今は作りたてなので、0 になっています",
],
[
MIND => "フィールド名を変えたい",
INPUT =>
"alter table <var>baz</var> <em>change</em> <var>name</var> <var>user_name</var> <var>varchar</var>(10);",
OUTPUT =>
"mysql> alter table <var>baz</var> change <var>name</var> <var>user_name</var> <var>varchar</var>(10);
Query OK, 0 rows affected (0.20 sec)
Records: 0  Duplicates: 0  Warnings: 0",
NOTE => "フィールド <q><var>name</var></q> を <q><var>user_name</var></q> に変えました。同時に型も変えます。フィールドと型は常に組です",
],
[
MIND => "確認",
INPUT =>
"desc <var>baz</var>;",
OUTPUT =>
"mysql> desc <var>baz</var>;
+-----------+-------------+------+-----+---------+-------+
| Field     | Type        | Null | Key | Default | Extra |
+-----------+-------------+------+-----+---------+-------+
| <var>id</var>        | <var>int</var>(11)     | YES  |     | NULL    |       |
| <em><var>user_name</var></em> | <em><var>varchar</var>(10)</em> | YES  |     | NULL    |       |
+-----------+-------------+------+-----+---------+-------+
2 rows in set (0.00 sec)",
NOTE => "確かにフィールド名が変わりました。同時に指定した型も変わっています",
],
[
MIND => "フィールドを追加したい",
INPUT =>
"alter table <var>baz</var> <em>add</em> <var>note</var> <var>text</var>;",
OUTPUT =>
"mysql> alter table <var>baz</var> add <var>note</var> <var>text</var>;
Query OK, 0 rows affected (0.01 sec)
Records: 0  Duplicates: 0  Warnings: 0",
NOTE => "フィールド <q><var>note</var></q> を、型 <q><var>text</var></q> で追加しました",
],
[
MIND => "確認",
INPUT =>
"desc <var>baz</var>;",
OUTPUT =>
"mysql> desc <var>baz</var>;
+-----------+-------------+------+-----+---------+-------+
| Field     | Type        | Null | Key | Default | Extra |
+-----------+-------------+------+-----+---------+-------+
| <var>id</var>        | <var>int</var>(11)     | YES  |     | NULL    |       |
| <var>user_name</var> | <var>varchar</var>(10) | YES  |     | NULL    |       |
| <em><var>note</var></em>      | <em><var>text</var></em>        | YES  |     | NULL    |       |
+-----------+-------------+------+-----+---------+-------+
3 rows in set (0.00 sec)",
NOTE => "",
],
[
MIND => "フィールドを削除したい",
INPUT =>
"alter table <var>baz</var> <em>drop</em> <var>note</var>;",
OUTPUT =>
"mysql> alter table <var>baz</var> drop <var>note</var>;
Query OK, 0 rows affected (0.20 sec)
Records: 0  Duplicates: 0  Warnings: 0",
NOTE => "",
],
[
MIND => "確認",
INPUT =>
"desc <var>baz</var>;",
OUTPUT =>
"mysql> desc <var>baz</var>;
+-----------+-------------+------+-----+---------+-------+
| Field     | Type        | Null | Key | Default | Extra |
+-----------+-------------+------+-----+---------+-------+
| <var>id</var>        | <var>int</var>(11)     | YES  |     | NULL    |       |
| <var>user_name</var> | <var>varchar</var>(10) | YES  |     | NULL    |       |
+-----------+-------------+------+-----+---------+-------+
2 rows in set (0.01 sec)",
NOTE => "消えました",
],
[
MIND => "テーブルにデータを登録してみる",
INPUT =>
"<em>insert into</em> <var>baz</var> values(1, 'テスト');",
OUTPUT =>
"mysql> insert into <var>baz</var> values(1, 'テスト');
Query OK, 1 row affected (0.01 sec)",
NOTE => "<q><var>id</var></q> を1、<q><var>user_name</var></q> を <q>テスト</q>",
],
[
MIND => "テーブルの状況はどう変わったかな？",
INPUT =>
"show table status\G",
OUTPUT =>
"mysql> show table status\G
*************************** 1. row ***************************
           Name: <var>baz</var>
         Engine: InnoDB
        Version: 10
     Row_format: Compact
           <em>Rows: 1</em>
 Avg_row_length: 16384
    Data_length: 16384
Max_data_length: 0
   Index_length: 0
      Data_free: 8388608
 Auto_increment: NULL
    Create_time: 2012-12-13 21:05:11
    Update_time: NULL
     Check_time: NULL
      Collation: utf8_general_ci
       Checksum: NULL
 Create_options: 
        Comment: 
1 row in set (0.00 sec)",
NOTE => "行数が0から1に変わりました",
],
[
MIND => "テーブルの中身を見たい",
INPUT =>
"<em>select</em> * from <var>baz</var>;",
OUTPUT =>
"mysql> select * from <var>baz</var>;
+------+-----------+
| <var>id</var>   | <var>user_name</var> |
+------+-----------+
|    1 | テスト    |
+------+-----------+
1 row in set (0.00 sec)",
NOTE => "文字化けしていたら、<q>set names</q> をやり直してみて下さい",
],
[
MIND => "さらにデータを追加",
INPUT =>
"insert into <var>baz</var> values(2, 'テスト2');",
OUTPUT =>
"mysql> insert into <var>baz</var> values(2, 'テスト2');
Query OK, 1 row affected (0.01 sec)",
NOTE => "",
],
[
MIND => "もっと追加",
INPUT =>
"insert into <var>baz</var> values(1, 'テスト3');",
OUTPUT =>
"mysql> insert into <var>baz</var> values(1, 'テスト3');
Query OK, 1 row affected (0.01 sec)",
NOTE => "",
],
[
MIND => "どうなったかな？",
INPUT =>
"select * from <var>baz</var>;",
OUTPUT =>
"mysql> select * from <var>baz</var>;
+------+------------+
| <var>id</var>   | <var>user_name</var>  |
+------+------------+
|    1 | テスト     |
|    2 | テスト2    |
|    1 | テスト3    |
+------+------------+
3 rows in set (0.00 sec)",
NOTE => "同じ <q><var>id</var></q> の行が２つある。これを許すのは困る場合がある",
],
[
MIND => "<q><var>id</var></q> のダブりを許したくない",
INPUT =>
"alter table <var>baz</var> add <em>primary&nbsp;key</em>(<var>id</var>);",
OUTPUT =>
"mysql> alter table <var>baz</var> add primary&nbsp;key(<var>id</var>);
ERROR 1062 (23000): Duplicate entry '1' for key 'PRIMARY'",
NOTE => "そのためには<q>primary&nbsp;key</q>を指定すれば良いが、現状ではエラーになる。すでに、<q><var>id</var></q>にダブりがあるため",
],
[
MIND => "<q><var>id</var></q>のダブりを解消する",
INPUT =>
"<em>delete</em> from <var>baz</var> <em>where</em> <var>user_name</var>='テスト3';",
OUTPUT =>
"mysql> delete from <var>baz</var> where <var>user_name</var>='テスト3';
Query OK, 1 row affected (0.01 sec)",
NOTE => "",
],
[
MIND => "確認",
INPUT =>
"select * from <var>baz</var>;",
OUTPUT =>
"mysql> select * from <var>baz</var>;
+------+------------+
| <var>id</var>   | <var>user_name</var>  |
+------+------------+
|    1 | テスト     |
|    2 | テスト2    |
+------+------------+
2 rows in set (0.00 sec)",
NOTE => "<q><var>id</var></q> のダブりは解消された",
],
[
MIND => "もう一度 primary&nbsp;key を設定してみる",
INPUT =>
"alter table <var>baz</var> add primary&nbsp;key(<var>id</var>);",
OUTPUT =>
"mysql> alter table <var>baz</var> add primary&nbsp;key(<var>id</var>);
Query OK, 2 rows affected (0.23 sec)
Records: 2  Duplicates: 0  Warnings: 0",
NOTE => "今度はエラーにならない",
],
[
MIND => "テーブルの構成を表示してみる",
INPUT =>
"desc <var>baz</var>;",
OUTPUT =>
"mysql> desc <var>baz</var>;
+-----------+-------------+------+-----+---------+-------+
| Field     | Type        | Null | Key | Default | Extra |
+-----------+-------------+------+-----+---------+-------+
| <var>id</var>        | <var>int</var>(11)     | NO   | <em>PRI</em> | 0       |       |
| <var>user_name</var> | <var>varchar</var>(10) | YES  |     | NULL    |       |
+-----------+-------------+------+-----+---------+-------+
2 rows in set (0.00 sec)",
NOTE => "<q><var>id</var></q> の <q>Key</q> が <q>PRI</q> になった",
],
[
MIND => "ダブった<q><var>id</var></q>でデータを追加してみる",
INPUT =>
"insert into <var>baz</var> values(1, 'テスト3');",
OUTPUT =>
"mysql> insert into <var>baz</var> values(1, 'テスト3');
ERROR 1062 (23000): Duplicate entry '1' for key 'PRIMARY'",
NOTE => "今度はエラーになる。これで <q><var>id</var></q> のダブりは起きない",
],
[
MIND => "primary&nbsp;key指定を解除することもできる",
INPUT =>
"alter table <var>baz</var> <em>drop</em> primary&nbsp;key;",
OUTPUT =>
"mysql> alter table <var>baz</var> drop primary&nbsp;key;
Query OK, 2 rows affected (0.21 sec)
Records: 2  Duplicates: 0  Warnings: 0",
NOTE => "",
],
[
MIND => "確認",
INPUT =>
"desc <var>baz</var>;",
OUTPUT =>
"mysql> desc <var>baz</var>;
+-----------+-------------+------+-----+---------+-------+
| Field     | Type        | Null | Key | Default | Extra |
+-----------+-------------+------+-----+---------+-------+
| <var>id</var>        | <var>int</var>(11)     | NO   |     | 0       |       |
| <var>user_name</var> | <var>varchar</var>(10) | YES  |     | NULL    |       |
+-----------+-------------+------+-----+---------+-------+
2 rows in set (0.00 sec)",
NOTE => "<q>PRI</q> が消えた",
],
[
MIND => "もう一度 primary&nbsp;key を設定",
INPUT =>
"alter table <var>baz</var> add primary&nbsp;key(<var>id</var>);",
OUTPUT =>
"mysql> alter table <var>baz</var> add primary&nbsp;key(<var>id</var>);
Query OK, 0 rows affected (0.27 sec)
Records: 0  Duplicates: 0  Warnings: 0",
NOTE => "",
],
[
MIND => "念のため確認",
INPUT =>
"desc <var>baz</var>;",
OUTPUT =>
"mysql> desc <var>baz</var>;
+-----------+-------------+------+-----+---------+-------+
| Field     | Type        | Null | Key | Default | Extra |
+-----------+-------------+------+-----+---------+-------+
| <var>id</var>        | <var>int</var>(11)     | NO   | <em>PRI</em> | 0       |       |
| <var>user_name</var> | <var>varchar</var>(10) | YES  |     | NULL    |       |
+-----------+-------------+------+-----+---------+-------+
2 rows in set (0.00 sec)",
NOTE => "復活",
],
[
MIND => "<q><var>id</var></q> は自動的に割り振られるようにしたい",
INPUT =>
"alter table <var>baz</var> <em>modify</em> <var>id</var> <var>int</var> <em>auto_increment</em>;",
OUTPUT =>
"mysql> alter table <var>baz</var> modify <var>id</var> <var>int</var> auto_increment;
Query OK, 2 rows affected (0.08 sec)
Records: 2  Duplicates: 0  Warnings: 0",
NOTE => "<q>auto_increment</q> という追加属性を付ける",
],
[
MIND => "確認",
INPUT =>
"desc <var>baz</var>;",
OUTPUT =>
"mysql> desc <var>baz</var>;
+-----------+-------------+------+-----+---------+----------------+
| Field     | Type        | Null | Key | Default | Extra          |
+-----------+-------------+------+-----+---------+----------------+
| <var>id</var>        | <var>int</var>(11)     | NO   | PRI | NULL    | <em>auto_increment</em> |
| <var>user_name</var> | <var>varchar</var>(10) | YES  |     | NULL    |                |
+-----------+-------------+------+-----+---------+----------------+
2 rows in set (0.00 sec)",
NOTE => "<q>Extra</q> に <q>auto_increment</q> 属性が追加された",
],
[
MIND => "<q><var>id</var></q> を指定せずにデータを追加してみる",
INPUT =>
"insert into <var>baz</var> <em>(</em><var>user_name</var><em>)</em> values('テスト4');",
OUTPUT =>
"mysql> insert into <var>baz</var> (<var>user_name</var>) values('テスト4');
Query OK, 1 row affected (0.01 sec)",
NOTE => "編集対象のフィールド名を指定するには、このようにする。<q>,</q> で区切って複数個でも良い",
],
[
MIND => "確認する",
INPUT =>
"select * from <var>baz</var>;",
OUTPUT =>
"mysql> select * from <var>baz</var>;
+----+------------+
| <var>id</var> | <var>user_name</var>  |
+----+------------+
|  1 | テスト     |
|  2 | テスト2    |
|  <em>3</em> | テスト4    |
+----+------------+
3 rows in set (0.00 sec)",
NOTE => "<q><var>id</var></q> が自動的に割り振られた",
],
[
MIND => "あたらしいテーブル <q><var>bar</var></q> を一気に作る",
INPUT =>
"create table <var>bar</var> (
  <var>id</var> <var>int</var> auto_increment primary&nbsp;key,
  <var>date</var> <var>date</var>,
  <var>item</var> <var>text</var>
);",
OUTPUT =>
"mysql> create table <var>bar</var> (
    ->   <var>id</var> <var>int</var> auto_increment primary&nbsp;key,
    ->   <var>date</var> <var>date</var>,
    ->   <var>item</var> <var>text</var>
    -> );
Query OK, 0 rows affected (0.23 sec)",
NOTE => "最初に作った <q><var>bar</var></q> は、その後 <q><var>baz</var></q> に名前を変えた",
],
[
MIND => "テーブル一覧が見たい",
INPUT =>
"show tables;",
OUTPUT =>
"mysql> show tables;
+---------------+
| Tables_in_<var>foo</var> |
+---------------+
| <var>bar</var>           |
| <var>baz</var>           |
+---------------+
2 rows in set (0.00 sec)",
NOTE => "テーブルが２つに増えた",
],
[
MIND => "フィールド名を指定してデータを追加",
INPUT =>
"insert into <var>bar</var> (<var>date</var>, <var>item</var>) values('2012/12/24', 'Xmas');",
OUTPUT =>
"mysql> insert into <var>bar</var> (<var>date</var>, <var>item</var>) values('2012/12/24', 'Xmas');
Query OK, 1 row affected (0.00 sec)",
NOTE => "<q><var>id</var></q> は自動割り振りなので指定していない",
],
[
MIND => "フィールド名と値の対応が取れていれば順番はどうでも良い",
INPUT =>
"insert into <var>bar</var> (<var>item</var>, <var>date</var>) values('お正月', '2013/1/1');",
OUTPUT =>
"mysql> insert into <var>bar</var> (<var>item</var>, <var>date</var>) values('お正月', '2013/1/1');
Query OK, 1 row affected (0.00 sec)",
NOTE => "このやり方の方が、テーブルのフィールド構成が変わっても安全にアクセスできる",
],
[
MIND => "テーブル内容を確認する",
INPUT =>
"select * from <var>bar</var>;",
OUTPUT =>
"mysql> select * from <var>bar</var>;
+----+------------+-----------+
| <var>id</var> | <var>date</var>       | <var>item</var>      |
+----+------------+-----------+
|  1 | 2012-12-24 | Xmas      |
|  2 | 2013-01-01 | お正月    |
+----+------------+-----------+
2 rows in set (0.00 sec)",
NOTE => "",
],
[
MIND => "データを変更したい",
INPUT =>
"<em>update</em> <var>bar</var> set <var>item</var>='<var>クリスマスイブ</var>' where <var>id</var>=<var>1</var>;",
OUTPUT =>
"mysql> update <var>bar</var> set <var>item</var>='<var>クリスマスイブ</var>' where <var>id</var>=<var>1</var>;
Query OK, 1 row affected (0.03 sec)
Rows matched: 1  Changed: 1  Warnings: 0",
NOTE => "",
],
[
MIND => "テーブル内容を確認する",
INPUT =>
"select * from <var>bar</var>;",
OUTPUT =>
"mysql> select * from <var>bar</var>;
+----+------------+----------------+
| id | date       | item           |
+----+------------+----------------+
|  1 | 2012-12-24 | クリスマスイブ |
|  2 | 2013-01-01 | お正月         |
+----+------------+----------------+
2 rows in set (0.00 sec)",
NOTE => "",
],
[
MIND => "テーブル名を変えたい",
INPUT =>
"rename table <var>bar</var> to <var>schedule</var>;",
OUTPUT =>
"mysql> rename table <var>bar</var> to <var>schedule</var>;
Query OK, 0 rows affected (0.01 sec)",
NOTE => "",
],
[
MIND => "テーブル一覧を確認",
INPUT =>
"show tables;",
OUTPUT =>
"mysql> show tables;
+---------------+
| Tables_in_<var>foo</var> |
+---------------+
| <var>baz</var>           |
| <var>schedule</var>      |
+---------------+
2 rows in set (0.00 sec)",
NOTE => "テーブル名が確かに変わっている",
],
[
MIND => "練習終了",
INPUT =>
"drop database <var>foo</var>;",
OUTPUT =>
"mysql> drop database <var>foo</var>;
Query OK, 2 rows affected (0.01 sec)",
NOTE => "データベース削除",
],
[
MIND => "ひとやすみ",
INPUT =>
"",
OUTPUT =>
"",
NOTE => "<em>マジで休んで下さい</em>",
],
[
MIND => "本番用データベースを作る",
INPUT =>
"create database <var>myschedule</var>;",
OUTPUT =>
"mysql> create database <var>myschedule</var>;
Query OK, 1 row affected (0.00 sec)",
NOTE => "もっともらしいデータベース名にする",
],
[
MIND => "データベース一覧を確認",
INPUT =>
"show databases;",
OUTPUT =>
"mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| information_schema |
| cdcol              |
| <em><var>myschedule</var></em>         |
| mysql              |
| performance_schema |
| phpmyadmin         |
| test               |
+--------------------+
7 rows in set (0.00 sec)",
NOTE => "",
],
[
MIND => "デフォルトのデータベースを選択",
INPUT =>
"use <var>myschedule</var>;",
OUTPUT =>
"mysql> use <var>myschedule</var>;
Database changed",
NOTE => "",
],
[
MIND => "テーブルを作る",
INPUT =>
"create table <var>schedule</var> (
  <var>id</var> <var>int</var> auto_increment primary&nbsp;key,
  <var>date</var> <var>date</var>,
  <var>item</var> <var>text</var>
);",
OUTPUT =>
"mysql> create table <var>schedule</var> (
    ->   <var>id</var> <var>int</var> auto_increment primary&nbsp;key,
    ->   <var>date</var> <var>date</var>,
    ->   <var>item</var> <var>text</var>
    -> );
Query OK, 0 rows affected (0.19 sec)",
NOTE => "",
],
[
MIND => "テーブル一覧を確認",
INPUT =>
"show tables;",
OUTPUT =>
"mysql> show tables;
+----------------------+
| Tables_in_<var>myschedule</var> |
+----------------------+
| <var>schedule</var>             |
+----------------------+
1 row in set (0.00 sec)",
NOTE => "",
],
[
MIND => "データベースへのアクセス権限を設定する",
INPUT =>
"<em>grant</em> all on <var>myschedule</var>.* to '<var>scheduleman</var>'@'localhost' identified by '<var>manpasswd</var>';",
OUTPUT =>
"mysql> grant all on <var>myschedule</var>.* to '<var>scheduleman</var>'@'localhost' identified by '<var>manpasswd</var>';
Query OK, 0 rows affected (0.01 sec)",
NOTE => "今まで <q><var>root</var></q> で作業してきたけど、本当は良くない。<q><var>scheduleman</var></q> というユーザ名はテキトー。このユーザーへ localhost 上でのアクセス権を与えた。パスワードは <q><var>manpasswd</var></q>。これもテキトー",
],
[
MIND => "リモートからのアクセスも許可しておく",
INPUT =>
"grant all on <var>myschedule</var>.* to '<var>scheduleman</var>'@'%' identified by '<var>manpasswd</var>';",
OUTPUT =>
"mysql> grant all on <var>myschedule</var>.* to '<var>scheduleman</var>'@'%' identified by '<var>manpasswd</var>';
Query OK, 0 rows affected (0.00 sec)",
NOTE => "<q>localhost</q> からと、リモートからのアクセスは両方設定する必要がある。<q>%</q> はワイルドカード",
],
[
MIND => "<q><var>scheduleman</var>@localhost</q> に対する権限の付与状況を確認",
INPUT =>
"show grants for '<var>scheduleman</var>'@'localhost'\G",
OUTPUT =>
"mysql> show grants for '<var>scheduleman</var>'@'localhost'\G
*************************** 1. row ***************************
Grants for <var>scheduleman</var>@localhost: GRANT USAGE ON *.* TO '<var>scheduleman</var>'@'localhost' IDENTIFIED BY PASSWORD '*A7EB75D3095B0B415EAA560CA53F46BFF7B47933'
*************************** 2. row ***************************
Grants for <var>scheduleman</var>@localhost: GRANT ALL PRIVILEGES ON `<var>myschedule</var>`.* TO '<var>scheduleman</var>'@'localhost'
2 rows in set (0.00 sec)",
NOTE => "パスワードは暗号化されている",
],
[
MIND => "同<q><var>scheduleman</var>@%</q>の権限を確認",
INPUT =>
"show grants for '<var>scheduleman</var>'@'%'\G",
OUTPUT =>
"mysql> show grants for '<var>scheduleman</var>'@'%'\G
*************************** 1. row ***************************
Grants for <var>scheduleman</var>@%: GRANT USAGE ON *.* TO '<var>scheduleman</var>'@'%' IDENTIFIED BY PASSWORD '*A7EB75D3095B0B415EAA560CA53F46BFF7B47933'
*************************** 2. row ***************************
Grants for <var>scheduleman</var>@%: GRANT ALL PRIVILEGES ON `<var>myschedule</var>`.* TO '<var>scheduleman</var>'@'%'
2 rows in set (0.00 sec)",
NOTE => "",
],
[
MIND => "一旦ログオフ",
INPUT =>
"<em>quit</em>",
OUTPUT =>
"mysql> quit
Bye",
NOTE => "一旦MySQLからログアウト。<q>exit</q>でもOK",
],
[
MIND => "先ほど権限を委譲したユーザーで入り直す",
INPUT =>
".\\mysql.exe -u <var>scheduleman</var> -p",
OUTPUT =>
"Enter password: *********
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is <var>121</var>
Server version: 5.5.28 Source distribution

Copyright (c) 2000, 2012, Oracle and/or its affiliates. All rights reserved.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> ",
NOTE => "パスワードは <q><var>manpasswd</var></q>",
],
[
MIND => "文字コードのおまじない",
INPUT =>
"set names <var>cp932</var>;",
OUTPUT =>
"mysql> set names <var>cp932</var>;
Query OK, 0 rows affected (0.00 sec)",
NOTE => "Macでは <q>utf8</q>",
],
[
MIND => "どんなデータベースがあったっけ？",
INPUT =>
"show databases;",
OUTPUT =>
"mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| information_schema |
| <var>myschedule</var>         |
| test               |
+--------------------+
3 rows in set (0.00 sec)",
NOTE => "<q><var>root</var></q> のときより少ない数しか見えない。より、安全",
],
[
MIND => "さっき作ったデータベースを選択",
INPUT =>
"use <var>myschedule</var>;",
OUTPUT =>
"mysql> use <var>myschedule</var>;
Database changed",
NOTE => "",
],
[
MIND => "テーブル一覧を確認",
INPUT =>
"show tables;",
OUTPUT =>
"mysql> show tables;
+----------------------+
| Tables_in_<var>myschedule</var> |
+----------------------+
| <var>schedule</var>             |
+----------------------+
1 row in set (0.00 sec)",
NOTE => "",
],
[
MIND => "テーブルの構成を確認",
INPUT =>
"desc <var>schedule</var>;",
OUTPUT =>
"mysql> desc <var>schedule</var>;
+-------+---------+------+-----+---------+----------------+
| Field | Type    | Null | Key | Default | Extra          |
+-------+---------+------+-----+---------+----------------+
| <var>id</var>    | <var>int</var>(11) | NO   | PRI | NULL    | auto_increment |
| <var>date</var>  | <var>date</var>    | YES  |     | NULL    |                |
| <var>item</var>  | <var>text</var>    | YES  |     | NULL    |                |
+-------+---------+------+-----+---------+----------------+
3 rows in set (0.00 sec)",
NOTE => "<q><var>root</var></q> で設定したときと変わらない",
],
[
MIND => "テーブル内容を見る",
INPUT =>
"select * from <var>schedule</var>;",
OUTPUT =>
"mysql> select * from <var>schedule</var>;
Empty set (0.00 sec)",
NOTE => "まずは空っぽ",
],
[
MIND => "データを入れる",
INPUT =>
"insert into <var>schedule</var> (<var>date</var>, <var>item</var>) values('2012/12/24', 'Xmas');",
OUTPUT =>
"mysql> insert into <var>schedule</var> (<var>date</var>, <var>item</var>) values('2012/12/24', 'Xmas');
Query OK, 1 row affected (0.00 sec)",
NOTE => "アクセス権が付与されているので可能になる操作",
],
[
MIND => "データを入れる",
INPUT =>
"insert into <var>schedule</var> (<var>item</var>, <var>date</var>) values('お正月', '2013/1/1');",
OUTPUT =>
"mysql> insert into <var>schedule</var> (<var>item</var>, <var>date</var>) values('お正月', '2013/1/1');
Query OK, 1 row affected (0.01 sec)",
NOTE => "",
],
[
MIND => "内容を確認",
INPUT =>
"select * from <var>schedule</var>;",
OUTPUT =>
"mysql> select * from <var>schedule</var>;
+----+------------+-----------+
| <var>id</var> | <var>date</var>       | <var>item</var>      |
+----+------------+-----------+
|  1 | 2012-12-24 | Xmas      |
|  2 | 2013-01-01 | お正月    |
+----+------------+-----------+
2 rows in set (0.00 sec)",
NOTE => "",
],
[
MIND => "絞り込んで内容を取り出す",
INPUT =>
"select * from <var>schedule</var> <em>where</em> <var>date</var>='2013/1/1';",
OUTPUT =>
"mysql> select * from <var>schedule</var> where <var>date</var>='2013/1/1';
+----+------------+-----------+
| <var>id</var> | <var>date</var>       | <var>item</var>      |
+----+------------+-----------+
|  2 | 2013-01-01 | お正月    |
+----+------------+-----------+
1 row in set (0.00 sec)",
NOTE => "条件に合致したレコードだけを取り出せる",
],
[
MIND => "他にも色々やってみよう！",
INPUT =>
"",
OUTPUT =>
"",
NOTE => "いよいよPHPとの連携です",
],
];
?>
<html>
<head>
  <title>SQL intro</title>
  <meta http-equiv=content-type content="text/html; charset=UTF-8">
  <link rel="stylesheet" href="sql_intro.css" type="text/css">
</head>
<body>
  <table><?php
      echo "<col/>\n";
      foreach($col as $k => $v) {
        echo "<col class=\"{$k}\"/>\n";
      }

      echo "<tr>\n";
      echo "<th></th>\n";
      foreach($col as $k => $v) {
        echo "<th>{$v[S]}</th>\n";
      }
      echo "</tr>\n";

      $n = count($item);
      for ($i = 0; $i < $n; $i++) {
      //foreach($item as $a) {
        $a = $item[$i];
        echo "<tr>\n";
        echo "<td><input type=\"checkbox\"/>".($i+1)."</td>";
        foreach($col as $k => $v) {
          $t = $v[TAG];
          $s = nl2br(str_replace("  ", "&nbsp;&nbsp;", $a[$k]));
          echo "<td><{$t}>{$s}</{$t}></td>\n";
        }
        echo "</tr>\n";
      }
  ?>
  </table>
</body>
</html>
