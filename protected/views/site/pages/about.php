<?php
$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About</h1>

<p class="main"><b>ht://Check is more than a link checker</b>. It's a console application written
for <b>GNU/Linux</b> systems in <b>C++</b> and derived from the best search engine available
on the Internet for free: <b><a href="http://www.htdig.org/">ht://Dig</a></b>.</p>

<p class="main">It can retrieve information through <b>HTTP/1.1</b> and store them
in a <b>MySQL</b> database, and it's particularly suitable
for small Internet domains or Intranet.</p>

<p class="main">Its purpose is to help a Webmaster managing one or more
related sites: after a "<i>crawl</i>", ht://Check creates a powerful data source
made up of information based on the retrieved documents. The kind of information
available to the ht://Check user includes:

<menu class="main">
<li class="main">single documents attributes such as: content-type, size, last modification
time, etc.; </li>
<li class="main">information regarding the retrieval process of a resource, like for instance
whether the resource was succesfully retrieved, or not, showing the various
results (the so-called <i>HTTP status codes</i>, as ht://Check uses this protocol for
crawling the Web);</li>
<li class="main">information regarding the structure of a document, basically its HTML link
tags, and the relationships they issue, in a <i>whole process</i> view:
basically, ht://Check is able to crawl a Web domain or set (in the algebrical
meaning), and links create sort of <i>inter-documents</i> relationships in it.
This feature, allows the user to get further information from the domain regarding:
   <menu>

      <li class="main">link results: if it either working or broken or redirected; also at
      the current status, it checks whether a link is actually an anchor that
      does not work, or it is a javascript or an e-mail;</li>
      <li class="main">the relationships between documents, in terms of incoming links and
      outgoing ones; in the future, particular attention in the development will
      be given to the Web structure mining activity.</li>
   </menu>
</li>
</menu>

<p class="main">A skinny report is given by the program <i>htcheck</i>, however
at the current situation most of the information is given by the PHP interface
which comes with the package and that is able to query the database built by the
htcheck program in a previously made crawl. It goes without saying that you need a
Web server to use it, and of course PHP with the MySQL connectivity module.</p>

<p class="main">By the way, as long as after a crawl ht://Check produces a
database on a MySQL server, it's needless to say that every user theoretically
could build its own information retrieval interface to this database; you only
need to know the structure of it, its tables and fields, and the relationships
among them. Other solutions are represented by independent scripts written by
using common scripting languages with MySQL connectivity modules (i.e. Perl and
Python), or faster programs written in C or C++ using MySQL API or wrapper
libraries (such as MySQL++ or dbconnect), or other Web driven solutions like
JSP, ColdFusion. There exists an interface to ht://Check for the Roxen Web
server written by Michael Stenitzer (stenitzer@eva.ac.at).</p>
