-- MySQL 
--
-- Host: localhost    Database: xlab
-- ------------------------------------------------------
--CTF user contron
CREATE USER 'ctf'@'%' IDENTIFIED BY '1234qwer'; 

GRANT SELECT ON `xlab`.`flag5` TO 'ctf'@'%';
GRANT SELECT ON `xlab`.`flag6` TO 'ctf'@'%';

DELETE FROM flag;
insert into flag values (1,'ydybyevbwufpjlgwhgbvmfpsljtymfxo');
insert into flag values (2,'vrcdidvpofygrpvybsaypsckswpjjkkd');
insert into flag values (3,'xpdznaqamfmjvecuftsqzquknvlzzeas');
insert into flag values (4,'bmnvzkseygalwfkdilalycvrelzkpwwa');
insert into flag values (5,'upjutbensrbzkdbytbulzlsnseeuuept');
insert into flag values (6,'pyjbhkpcqkmgrwegsgsjptejmrjhnsjr');
insert into flag values (7,'dfjbqwdbnbhfimtqhtzcetfnpzkxdnvu');
insert into flag values (8,'eqkulevrrobsosynaqhtdatgvrnzyfhh');
insert into flag values (9,'bucdrydpqidwbzatsehvfrcsuczcfljt');
insert into flag values (10,'dmjuzfaobaxjwvinmblcwskhywwsddyh');
insert into flag values (11,'ifizsfztetkeegmdxgtudkcfwwzjvkpd');
insert into flag values (12,'anxnkgqnflenoarqkyzyoujbibplaoxy');
insert into flag values (13,'znacnjgyrxmmzxyzrfhdtbbmjentcoro');
insert into flag values (14,'onfywjywpanqrfdvhdijunnhipqyizvd');
insert into flag values (15,'tunrvnwqbqaxsyrlezrjrzzgcltmbvly');
insert into flag values (16,'techzlhcuqbxgiivwabrafqllutvzgwu');
insert into flag values (17,'jfebsqlbmrxiofcufyabhikkvpmfqtgj');
insert into flag values (18,'upuzdmwkckzhkhuyuusfizafhyzypsxa');
insert into flag values (19,'vcrwnusjufpqnqparsabyussxdcxymgf');
insert into flag values (20,'bsmgnvtbeqtncigybscescyxwfobhexg');
insert into flag values (21,'vhobdphfqbymrlpbnjoxhaplslceysnl');
insert into flag values (22,'sfcufvogcswddjomtyswsgbdvrzbshda');
insert into flag values (23,'xqhtzvwjwbkamairrypuxfjakdeidajg');
insert into flag values (24,'vwkibkbsfktjurztybkxoxwxatvakdwa');
insert into flag values (25,'gubeddczlwcfkbrxavpdhubonmwogjme');
insert into flag values (26,'ogbqpalugdmcbcbvkbbtmhfmoxnmytoa');
insert into flag values (27,'wyyhmdtvwcdgphitinzilfmezuvyadex');
insert into flag values (28,'hoqrsjjxrxqwqazarhlkcjbcagmqvzxh');
insert into flag values (29,'tyydvqadrkkrpwvxhlksamzonmragnpz');
insert into flag values (30,'aonltpoyvzxoxrepbezoivvhmnasmjab');

DELETE from flag5;
insert into `flag5` (`Id`, `flag`, `msg`) values('1','asd','i dot know');
insert into `flag5` (`Id`, `flag`, `msg`) values('2','ts','test abasdf');
insert into `flag5` (`Id`, `flag`, `msg`) values('3','abc','abc jxust');
insert into `flag5` (`Id`, `flag`, `msg`) values('4','upjutbensrbzkdbytbulzlsnseeuuept','this is correct  five flag');
insert into `flag5` (`Id`, `flag`, `msg`) values('5','test','bb');

DELETE from flag6;
insert into `flag6` (`Id`, `flag`, `msg`) values('1','GZCinXAK@WFJQ#zd^(hqOEspgIPTBVyM','test abc');
insert into `flag6` (`Id`, `flag`, `msg`) values('2','%CqPQb&Vyp(ZYAeLWIfF@vkX*w#iMrSA','123564');
insert into `flag6` (`Id`, `flag`, `msg`) values('3','pyjbhkpcqkmgrwegsgsjptejmrjhnsjr','this is the vaild six flag');
insert into `flag6` (`Id`, `flag`, `msg`) values('4','%CqPQb&Vyp(ZYAeLWIfF@vkX*w#iMrSA','bzxc');
insert into `flag6` (`Id`, `flag`, `msg`) values('5','%CqPQb&Vyp(ZYAeLWIfF@vkX*w#iMrSA','6443');
