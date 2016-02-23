drop database mydb;
use mydb;

insert into personal(personal_name,personal_sex,personal_date,personal_nation,personal_origin,
				personal_country,personal_province,personal_city,personal_address,personal_phone_num,
				personal_email,personal_fax,personal_zipcode,personal_remarks) 
values('龚成',0,1477000000,'苗','重庆','中国','天津','天津','','15620625044','13648225189$163.com','','300071','高富帅');
select * from personal;

insert into `group`(group_name,group_remarks)
	values('天宫慈善部','专管人间不平事');
select * from `group`;

insert into company(company_name,company_address,company_zipcode,company_phone_num,company_email,company_fax,company_remarks) 
values('tengxun','深圳','518000','0755-83765566','service@QQ.com',' ','深圳市');
select * from company;

insert into company(company_name,company_address,company_zipcode,company_phone_num,company_email,company_fax,company_remarks) 
values('迅雷','深圳','518000','0755-83765566','service@xunlei.com',null,'深圳阿斯顿市');
select * from company;

insert into `group`(group_name,group_remarks) 
values('凤舞九天','大家一起来看表演');
select * from `group`;

insert into pro_manage_dept(pro_manage_dept_name) values('保卫处');
select * from pro_manage_dept;

insert into fundrise_person(fundrise_person_name,fundrise_person_dept_id,fundrise_person_Landline,fundrise_person_cellphone,fundrise_person_email,fundrise_person_fax,fundrise_person_zipcode)
 values('龚成',1,'022-123456',null,null,null,null);
select * from fundrise_person;
-- INSERT INTO `fundrise_person` (`pro_manage_dept_name`) VALUES ('徐志江');

insert into project_type(project_type_name) values('奖学金');
select * from project_type;

-- 此处做项目状态和项目类型的添加
insert into project_level(project_level_name)
values('院级');
insert into project_level(project_level_name)
values('校级');
select * from project_level;
-- 此处做项目状态的添加
insert into project_state(project_state_name)
values('未开始');
insert into project_state(project_state_name)
values('进行中');
insert into project_state(project_state_name)
values('已结束');
select * from project_state;

insert into donate_type(donate_type_name) values('现金');
select * from donate_type;

insert into approved(approved_name,approved_dept_id,approved_landline,approved_cellphone,approved_email,approved_fax,approved_zipcode) 
values('龚成',1,'020-123456',null,null,null,null);
select * from approved;

insert into project(project_name,project_date,project_recorder_id,project_lastedit_id,project_manage_id,project_fundrise_id,project_type_id,project_state_id,project_level_id,project_remarks)
 values('航天奖学金',1477065600,'徐志江','徐志江',1,1,1,1,1,'为我国航天事业献身');
select * from project;

use mydb;
select personal_id as id,personal_name as name from personal;
-- 插入捐赠记录
-- 机构捐赠实例
insert into donated_funds(donated_funds_project_id,donated_funds_amount,donated_funds_date,donated_funds_donatetype_id,donated_funds_recorder_id,donated_funds_lastedit_id,donated_funds_currency,donated_funds_remarks)
 values(1,1000000,1477065600,1,'徐志江','徐志江','人民币','为我国航天事业献身');
select * from donated_funds;
-- 个人捐赠实例
insert into donated_funds(donated_funds_project_id,donated_funds_amount,donated_funds_date,donated_funds_donatetype_id,donated_funds_recorder_id,donated_funds_lastedit_id,donated_funds_currency,donated_funds_remarks)
 values(1,99999999,1476065600,1,'徐志江','徐志江','人民币','为我国航天事业献身');
select * from donated_funds;
-- 集体捐赠实例
insert into donated_funds(donated_funds_project_id,
							donated_funds_amount,
							donated_funds_date,
							donated_funds_donatetype_id,
							donated_funds_recorder_id,
							donated_funds_lastedit_id,
							donated_funds_currency,
							donated_funds_remarks)
 values(1,324599,1475065600,1,'徐志江','徐志江','人民币','为我国航天事业献身');
select * from donated_funds;

desc donate;
select * from company;
insert into donate(donate_group_id,
					donate_personal_id,
					donate_company_id,
					donate_donated_funds_id,
					donate_customer_type) 
values(null,null,1,1,2);
select * from donate;

insert into donate(donate_group_id,donate_personal_id,donate_company_id,donate_donated_funds_id,donate_customer_type) 
values(null,1,null,2,0);
select * from donate;

insert into donate(donate_group_id,donate_personal_id,donate_company_id,donate_donated_funds_id,donate_customer_type) 
values(2,null,null,3,1);
select * from donate;



select project_name as '所属项目',donated_funds_amount as '价值',donate_type_name as '捐赠类型',donate_customer_type as '客户类型',personal_name as '捐赠人',donated_funds_recorder_id as '录入人',donated_funds_lastedit_id as '最后编辑',donated_funds_date as '捐赠时间'
from donated_funds inner join project on donated_funds_project_id=project_id
				   inner join donate_type on donated_funds_donatetype_id=donate_type_id
				   inner join donate on donated_funds_id=donate_donated_funds_id and donate_customer_type=0
				   inner join personal on donate_personal_id=personal_id;

select project_name as '所属项目',
		donated_funds_amount as '价值',
		donate_type_name as '捐赠类型',
		donate_customer_type as '客户类型',
		group_name as '捐赠集体',
		donated_funds_recorder_id as '录入人',
		donated_funds_lastedit_id as '最后编辑',
		donated_funds_date as '捐赠时间'
from donated_funds inner join project on donated_funds_project_id=project_id
				   inner join donate_type on donated_funds_donatetype_id=donate_type_id
				   inner join donate on donated_funds_id=donate_donated_funds_id and donate_customer_type=1
				   inner join `group` on donate_group_id=group_id
;

select * from company;

select project_name as '所属项目',
		donated_funds_amount as '价值',
		donate_type_name as '捐赠类型',
		donate_customer_type as '客户类型',
		company_name as '捐赠机构',
		donated_funds_recorder_id as '录入人',
		donated_funds_lastedit_id as '最后编辑',
		donated_funds_date as '捐赠时间'
from donated_funds inner join project on donated_funds_project_id=project_id
				   inner join donate_type on donated_funds_donatetype_id=donate_type_id
				   inner join donate on donated_funds_id=donate_donated_funds_id and donate_customer_type=2
				   inner join company on donate_company_id=company_id;


-- 搜索部分
use mydb;

-- select * from donated_funds,project,donate_type,donate;
-- 搜索pro_manage_dept

select pro_manage_dept_id as 'id',pro_manage_dept_name as 'name'
from pro_manage_dept;
select pro_manage_dept_id as 'id',pro_manage_dept_name as 'name'
from pro_manage_dept where pro_manage_dept_name = '保卫处';

select fundrise_person_id as 'id',fundrise_person_name as 'name' 
from fundrise_person;

select project_type_id as 'id',project_type_name as 'name'
from project_type;
select donate_type_id as 'id',donate_type_name as 'name' 
from donate_type;

select personal_id as 'id',personal_name as 'name',0 as 'type'
from personal;

select group_id as 'id',group_name as 'name',1 as 'type'
from m_group;

select company_id as 'id',company_name as 'name',2 as 'type'
from company;

insert into intercourse(intercourse_theme,intercourse_date,intercourse_recorder_id,intercourse_lastedit_id,intercourse_content)
 values('两岸交流会',1377065600,'徐志江','徐志江','为促进海峡两岸交流');
select intercourse_id as 'id',intercourse_theme as 'theme'
from intercourse;

use mydb;
select * from purpose;
insert into purpose(purpose_name) values('专项使用');
-- update purpose set purpose_name='奖学金' where purpose_id=3;

select * from pro_manage_dept;

use mydb;

select approved_id as id,approved_name as name,pro_manage_dept_name,approved_landline,approved_cellphone,approved_email,approved_fax,approved_zipcode
from approved inner join pro_manage_dept on approved_dept_id=pro_manage_dept_id;

-- alter table news add news_date int not null;
-- alter table news change news_title news_name varchar(45) not null;
select news_id as id,news_name as title,news_link as '链接',news_date as '最后编辑',news_remark as '备注' 
from news;

insert into news(news_name,news_link,news_date,news_remark)
values('葫芦娃大战奥特曼','www.xinwen.com',146357445,'南开大学突现葫芦娃大战奥特曼现象');

select donate_type_id as id,donate_type_name as name
 from donate_type;


select pro_manage_dept_id as id,pro_manage_dept_name as name
from pro_manage_dept;

select *
from fundrise_person;

select fundrise_person_id as id,fundrise_person_name as name,pro_manage_dept_name '所属部门',fundrise_person_landline as '座机',fundrise_person_cellphone as '手机',fundrise_person_email as '邮箱',fundrise_person_fax as '传真',fundrise_person_zipcode as '邮编'
from fundrise_person inner join pro_manage_dept on fundrise_person_dept_id=pro_manage_dept_id;

select * from project_type;

insert into spend_funds(spend_funds_project_id,
spend_funds_amount,
spend_funds_recorder_id,
spend_funds_lastedit_id,
spend_funds_date,
spend_funds_purpose_id,
spend_funds_remarks,
spend_funds_aproved_dept_id,
spend_funds_manage_id,
spend_funds_approved_id,
spend_funds_benefit_dept_id)
values(1,3000,'徐志江','徐志江',14456453,1,'',1,1,1,1);

use mydb;
select * from spend_funds;

select project_name as '项目名称',
spend_funds_amount as '金额',
purpose_name as '资金用途',
spend_funds_recorder_id as '记录人',
spend_funds_lastedit_id as '最后编辑',
approved_dept.pro_manage_dept_name as '执行部门',
approved_name as '批准人',
benefit_dept.pro_manage_dept_name as '受益部门',
fundrise_person_name as '经办人',
spend_funds_date as '日期'
from spend_funds inner join project on spend_funds_project_id=project_id
				 inner join purpose on spend_funds_purpose_id=purpose_id
				 inner join pro_manage_dept approved_dept on approved_dept.pro_manage_dept_id=spend_funds_aproved_dept_id
				 inner join approved on spend_funds_approved_id=approved_id
				 inner join pro_manage_dept benefit_dept on benefit_dept.pro_manage_dept_id=spend_funds_benefit_dept_id
				 inner join fundrise_person on spend_funds_manage_id=fundrise_person_id;

use mydb;

select * from project;

select  project_id as id,
		project_name as 'name',
		project_recorder_id as '记录人',
		project_lastedit_id as '最后编辑',
		pro_manage_dept_name as '管理部门',
		fundrise_person_name as '筹款专员',
		project_type_name as '项目类型',
		project_state_name as '项目状态',
		project_level_name as '项目级别',
		totle_donated as '总捐赠',
		totle_spend as '总支出',
		totle_donated-totle_spend as '剩余',
		project_date as '日期'
		-- sum(donated_funds_amount) as '捐赠金额',
		-- sum(spend_funds_amount) as '支出金额',
		-- project_remarks as '备注'
from project inner join pro_manage_dept on project_manage_id=pro_manage_dept_id
			 inner join fundrise_person on project_fundrise_id=fundrise_person_id
			 inner join project_type on project_type.project_type_id=project.project_type_id
			 inner join project_state on project_state.project_state_id=project.project_state_id
			 inner join project_level on project_level.project_level_id=project.project_level_id
			 inner join (select project_id as all_donated_id,
								case when sum(donated_funds_amount) is null then 0 else sum(donated_funds_amount) end
								as totle_donated
						 from project left outer join donated_funds on project_id=donated_funds_project_id
						 -- where project.project_id=donated_funds_project_id
						 group by project_id) all_donated on all_donated_id=project.project_id
			 inner join (select project_id as all_spend_id,
								case when sum(spend_funds_amount) is null then 0 else sum(spend_funds_amount) end
								as totle_spend
						 from project left outer join spend_funds on project_id=spend_funds_project_id
						 group by project_id) all_spend on all_spend_id=project.project_id
;

use mydb;
			
-- 	 inner join donated_funds on project_id=donated_funds_project_id
	-- 	 	 inner join spend_funds on project_id=spend_funds_project_id
-- group by project_id
use mydb;
select * from intercourse;

insert into join_intercourse(
			group_group_id,
			personal_personal_id,
			company_company_id,
			intercourse_intercourse_id)
values(1,null,null,1);
select * from join_intercourse;
-- 改变为一对多
-- alter table join_intercourse 
-- change intercourse_intercourse_id 
-- intercourse_intercourse_id int not null;
-- 个人客户
select  intercourse_id as id,
		'个人' as '客户类型',
		personal_name as '客户',
		intercourse_theme as '活动主题',
		intercourse_recorder_id as '记录人',
		intercourse_lastedit_id as '最后编辑',
		intercourse_date as '日期'
from intercourse inner join join_intercourse on intercourse_id=intercourse_intercourse_id
				 inner join personal on personal_personal_id=personal_id;
-- 集体客户
select  intercourse_id as id,
		'集体' as '客户类型',
		group_name as '客户',
		intercourse_theme as '活动主题',
		intercourse_recorder_id as '记录人',
		intercourse_lastedit_id as '最后编辑',
		intercourse_date as '日期'
from intercourse inner join join_intercourse on intercourse_id=intercourse_intercourse_id
				 inner join `group` on group_group_id=group_id;
-- 公司客户
select  intercourse_id as id,
		'机构' as '客户类型',
		company_name as '客户',
		intercourse_theme as '活动主题',
		intercourse_recorder_id as '记录人',
		intercourse_lastedit_id as '最后编辑',
		intercourse_date as '日期'
from intercourse inner join join_intercourse on intercourse_id=intercourse_intercourse_id
				 inner join company on company_company_id=company_id;

select * from personal;
use mydb;
select 	'个人' as '客户类型',
		personal_name as 'name',
		personal_sex as '性别',
		personal_date as '生日',
		personal_nation as '民族',
		personal_origin as '籍贯',
		personal_country as '国家',
		personal_province as '省市',
		personal_city as '城市',
		personal_address as '详细地址',
		personal_phone_num as '联系电话',
		personal_email as '个人邮箱',
		personal_fax as '传真',
		personal_zipcode as '邮编',
		personal_remarks as '备注'
from personal
where personal_id=1;

select '集体' as '客户类型',
		group_name as 'name',
		group_remarks as '备注'
from `group`
where group_id=1;
alter table m_group rename `group`;



select '机构' as '客户类型',
		company_id,
		company_name as 'name',
		company_address as '地址',
		company_zipcode as '邮编',
		company_phone_num as '联系电话',
		company_email as '机构邮箱',
		company_fax as '传真',
		company_remarks as '备注'
from company;

insert into `group`(group_name,group_remarks) values('','');
select *from `group`;
delete from `group` where group_id>=3;
delete from company where company_id>=4;
desc `group`;
use mydb;
-- 获取个人管理的集体
insert into manage_group(personal_personal_id,group_group_id) values(1,1);
insert into manage_company(personal_personal_id,company_company_id) values(1,1);

select personal_id as id,personal_name as '管理者'
from personal inner join manage_group on personal_id=personal_personal_id
			  inner join `group` on group_group_id=group_id;

select company_id as id,personal_name as '管理者',company_name as '机构名称'
from personal inner join manage_company on personal_id=personal_personal_id
			  inner join `company` on company_company_id=company_id;

-- 机构所属人员
insert into group_have(group_group_id,personal_personal_id) values(1,1);
insert into group_have(group_group_id,personal_personal_id) values(2,1);
insert into group_have(group_group_id,personal_personal_id) values(7,1);

insert into group_have(group_group_id,personal_personal_id) values(1,2);
insert into group_have(group_group_id,personal_personal_id) values(1,3);

select personal_id as id,group_name as '集体名称',personal_name as '成员'
from personal inner join group_have on personal_id=personal_personal_id
			  inner join `group` on group_group_id=group_id;

insert into company_have(company_company_id,personal_personal_id) values(1,1);
insert into company_have(company_company_id,personal_personal_id) values(1,2);
insert into company_have(company_company_id,personal_personal_id) values(1,3);

select personal_id as id,company_name as '机构名称',personal_name as '成员'
from personal inner join company_have on personal_id=personal_personal_id
			  inner join `company` on company_company_id=company_id;

select * from personal;
select * from `group`;
select * from company;
select * from group_have;

UPDATE `donate` SET `donate_personal_id`='',`donate_company_id`='',`donate_customer_type`='1',`donate_group_id`='11' WHERE donate_donated_funds_id=5;
UPDATE `donate` SET `donate_personal_id`=null,`donate_company_id`=null,`donate_customer_type`='1',`donate_group_id`='11' WHERE donate_donated_funds_id=5;
-- select * from personal;
-- update personal set personal_email='13648225189@163.com' where personal_id=1;
use mydb;
desc spend_funds;
select * from spend_funds;
INSERT INTO `spend_funds` (`spend_funds_project_id`,`spend_funds_amount`,`spend_funds_recorder_id`,`spend_funds_lastedit_id`,`spend_funds_date`,`spend_funds_purpose_id`,`spend_funds_remarks`,`spend_funds_aproved_dept_id`,`spend_funds_manage_id`,`spend_funds_approved_id`,`spend_funds_benefit_dept_id`) 
VALUES ('1','5356345','徐志江','徐志江',1440344388,'1',null,'1','1','1','1');

select * from fundrise_person;
select * from project;

use mydb;
select 	news_name as 'title',
		news_link as '链接',
		news_date as '日期',
		news_remark as '备注'
from 	pro_have_news inner join news on news_news_id=news_id
					  inner join project on project_project_id=project_id;

select news_id as id,news_name as title,news_link as '链接',news_date as '日期',news_remark as '备注'
from news;

select project_name as '项目名称',
		news_id,
		news_name as 'title',
		news_link as '链接',
		news_date as '日期',
		news_remark as '备注'
from pro_have_news inner join news on news_news_id=news_id
					  inner join project on project_project_id=project_id
where project_id=1;

insert into pro_have_news values(1,2);

select * from join_intercourse;
insert into join_intercourse values(1,1,1,1);
insert into join_intercourse(group_group_id,personal_personal_id,company_company_id,
			intercourse_intercourse_id) values(null,null,2,1);
insert into join_intercourse values(null,null,3,1);
use mydb;
desc join_intercourse;
alter table join_intercourse change intercourse_intercourse_id 
intercourse_intercourse_id int null unique;
alter table join_intercourse change join_intercourse_id
join_intercourse_id int primary key unique not null auto_increment;
-- 进行intercourse设置
select * from intercourse where intercourse_theme='两岸交流会';

select *
from intercourse inner join join_intercourse on intercourse_id=intercourse_intercourse_id
				 inner join `personal` on personal_personal_id=personal_id
where intercourse_id=1;
use mydb;
select * from spend_funds;
 INSERT INTO `spend_funds` (
			`spend_funds_project_id`,
			`spend_funds_amount`,
			`spend_funds_recorder_id`,
			`spend_funds_lastedit_id`,
			`spend_funds_lastedit_date`,
			`spend_funds_date`,
			`spend_funds_purpose_id`,
			`spend_funds_remarks`,
			`spend_funds_aproved_dept_id`,
			`spend_funds_manage_id`,
			`spend_funds_approved_id`,
			`spend_funds_benefit_dept_id`) 
VALUES (null,'190.73','龚成','龚成',1441015473,1440979200,'1','阿道夫','1','1','1','1');
