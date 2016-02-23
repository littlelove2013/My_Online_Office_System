<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>其他菜单</title>
<style type="text/css">
/* common styling */
/* set up the overall width of the menu div, the font and the margins */
.menu {
font-family: arial, sans-serif; 
width:100%; 
margin:0; 
margin:50px 0;
}
/* remove the bullets and set the margin and padding to zero for the unordered list */
.menu ul {
padding:0; 
margin:0;
list-style-type: none;
}
/* float the list so that the items are in a line and their position relative so that the drop down list will appear in the right place underneath each list item */
.menu ul li {
float:left; 
position:relative;
}
/* style the links to be 104px wide by 30px high with a top and right border 1px solid white. Set the background color and the font size. */
.menu ul li a, .menu ul li a:visited {
display:block; 
text-align:center; 
text-decoration:none; 
width:104px; 
height:30px; 
color:#000; 
border:1px solid #fff;
border-width:1px 1px 0 0;
background:#c9c9a7; 
line-height:30px; 
font-size:11px;
}
/* make the dropdown ul invisible */
.menu ul li ul {
display: none;
}
/* specific to non IE browsers */
/* set the background and foreground color of the main menu li on hover */
.menu ul li:hover a {
color:#fff; 
background:#b3ab79;
}
/* make the sub menu ul visible and position it beneath the main menu list item */
.menu ul li:hover ul {
display:block; 
position:absolute; 
top:31px; 
left:0; 
width:105px;
}
/* style the background and foreground color of the submenu links */
.menu ul li:hover ul li a {
display:block; 
background:#faeec7; 
color:#000;
}
/* style the background and forground colors of the links on hover */
.menu ul li:hover ul li a:hover {
background:#dfc184; 
color:#000;
}
</style>
<!--[if lte IE 6]>
<style type="text/css">
/* styling specific to Internet Explorer IE5.5 and IE6. Yet to see if IE7 handles li:hover */
/* Get rid of any default table style */
table {
border-collapse:collapse;
margin:0; 
padding:0;
}
/* ignore the link used by 'other browsers' */
.menu ul li a.hide, .menu ul li a:visited.hide {
display:none;
}
/* set the background and foreground color of the main menu link on hover */
.menu ul li a:hover {
color:#fff; 
background:#b3ab79;
}
/* make the sub menu ul visible and position it beneath the main menu list item */
.menu ul li a:hover ul {
display:block; 
position:absolute; 
top:32px; 
left:0; 
width:105px;
}
/* style the background and foreground color of the submenu links */
.menu ul li a:hover ul li a {
background:#faeec7; 
color:#000;
}
/* style the background and forground colors of the links on hover */
.menu ul li a:hover ul li a:hover {
background:#dfc184; 
color:#000;
}
</style>
<![endif]-->
</head>
<body>
<div class="menu">
<ul>
<li><a class="hide" href="#">捐赠相关</a>
<!--[if lte IE 6]>
<a href="../menu/index.html">DEMOS
<table><tr><td>
<![endif]-->
    <ul>
    <li><a href="donate_related/donate_type">捐赠类型</a></li>
    <!--
    <li><a href="../menu/zero_dollars.html" title="The zero dollar ads page">zero dollars</a></li>
    <li><a href="../menu/embed.html" title="Wrapping text around images">wrapping text</a></li>
    <li><a href="../menu/form.html" title="Styling forms">styled form</a></li>
    <li><a href="../menu/nodots.html" title="Removing active/focus borders">active focus</a></li>
    <li><a href="../menu/shadow_boxing.html" title="Multi-position drop shadow">shadow boxing</a></li>
    <li><a href="../menu/old_master.html" title="Image Map for detailed information">image map</a></li>
    <li><a href="../menu/bodies.html" title="fun with background images">fun backgrounds</a></li>
    <li><a href="../menu/fade_scroll.html" title="fade-out scrolling">fade scrolling</a></li>
    <li><a href="../menu/em_images.html" title="em size images compared">em sized images</a></li>
    -->
    </ul>
<!--[if lte IE 6]>
</td></tr></table>
</a>
<![endif]-->
</li>
<li><a class="hide" href="#">项目管理相关</a>
<!--[if lte IE 6]>
<a href="index.html">MENUS
<table><tr><td>
<![endif]-->
    <ul>
    	<li><a href="project_related/project_type/">项目类型</a></li>
        <li><a href="project_related/pro_manage_dept/">部门管理</a></li>
        <li><a href="project_related/fundrise_person/">筹款专员</a></li>
    <!--
    <li><a href="spies.html" title="a coded list of spies">spies menu</a></li>
    <li><a href="vertical.html" title="a horizontal vertical menu">vertical menu</a></li>
    <li><a href="expand.html" title="an enlarging unordered list">enlarging list</a></li>
    <li><a href="enlarge.html" title="an unordered list with link images">link images</a></li>
    <li><a href="cross.html" title="non-rectangular links">non-rectangular</a></li>
    <li><a href="jigsaw.html" title="jigsaw links">jigsaw links</a></li>
    <li><a href="circles.html" title="circular links">circular links</a></li>
    -->
    </ul>
<!--[if lte IE 6]>
</td></tr></table>
</a>
<![endif]-->
</li>
<li><a class="hide" href="#">支出相关</a>
<!--[if lte IE 6]>
<a href="../layouts/index.html">LAYOUTS
<table><tr><td>
<![endif]-->
    <ul>
    	<li>
            <a href="spend_related/approved">审批人管理</a>
        </li>
        <li>
            <a href="spend_related/purpose">资金用途管理</a>
        </li>
    <!--
    <li><a href="../layouts/bodyfix.html" title="Cross browser fixed layout">Fixed 1</a></li>
    <li><a href="../layouts/body2.html" title="Cross browser fixed layout">Fixed 2</a></li>
    <li><a href="../layouts/body4.html" title="Cross browser fixed layout">Fixed 3</a></li>
    <li><a href="../layouts/body5.html" title="Cross browser fixed layout">Fixed 4</a></li>
    <li><a href="../layouts/minimum.html" title="A simple minimum width layout">minimum width</a></li>
    -->
    </ul>
<!--[if lte IE 6]>
</td></tr></table>
</a>
<![endif]-->
</li>
<li><a class="hide" href="#">新闻相关</a>
<!--[if lte IE 6]>
<a href="../boxes/index.html">BOXES
<table><tr><td>
<![endif]-->
    <ul>
    	<li>
            <a href="news/manageNews">新闻管理</a>
        </li>
    <!--
    <li><a href="spies.html" title="a coded list of spies">spies menu</a></li>
    <li><a href="vertical.html" title="a horizontal vertical menu">vertical menu</a></li>
    <li><a href="expand.html" title="an enlarging unordered list">enlarging list</a></li>
    <li><a href="enlarge.html" title="an unordered list with link images">link images</a></li>
    <li><a href="cross.html" title="non-rectangular links">non-rectangular</a></li>
    <li><a href="jigsaw.html" title="jigsaw links">jigsaw links</a></li>
    <li><a href="circles.html" title="circular links">circular links</a></li>
    -->
    </ul>
<!--[if lte IE 6]>
</td></tr></table>
</a>
<![endif]-->
</li>
	
</ul>
<!-- clear the floats if required -->
<div class="clear"> </div>
</div>
</body>
</html>