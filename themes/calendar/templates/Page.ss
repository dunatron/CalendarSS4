<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
	<% base_tag %>
	$MetaTags(false)
    <title>One Ring Rentals: $Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
	<script src="http:/html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <%--<link rel="apple-touch-icon" sizes="57x57" href="themes/one-ring/images/favicon/apple-icon-57x57.png">--%>
    <%--<link rel="apple-touch-icon" sizes="60x60" href="themes/one-ring/images/favicon/apple-icon-60x60.png">--%>
    <%--<link rel="apple-touch-icon" sizes="72x72" href="themes/one-ring/images/favicon/apple-icon-72x72.png">--%>
    <%--<link rel="apple-touch-icon" sizes="76x76" href="themes/one-ring/images/favicon/apple-icon-76x76.png">--%>
    <%--<link rel="apple-touch-icon" sizes="114x114" href="themes/one-ring/images/favicon/apple-icon-114x114.png">--%>
    <%--<link rel="apple-touch-icon" sizes="120x120" href="themes/one-ring/images/favicon/apple-icon-120x120.png">--%>
    <%--<link rel="apple-touch-icon" sizes="144x144" href="themes/one-ring/images/favicon/apple-icon-144x144.png">--%>
    <%--<link rel="apple-touch-icon" sizes="152x152" href="themes/one-ring/images/favicon/apple-icon-152x152.png">--%>
    <%--<link rel="apple-touch-icon" sizes="180x180" href="themes/one-ring/images/favicon/apple-icon-180x180.png">--%>
    <%--<link rel="icon" type="image/png" sizes="192x192"  href="themes/one-ring/images/favicon/android-icon-192x192.png">--%>
    <%--<link rel="icon" type="image/png" sizes="32x32" href="themes/one-ring/images/favicon/favicon-32x32.png">--%>
    <%--<link rel="icon" type="image/png" sizes="96x96" href="themes/one-ring/images/favicon/favicon-96x96.png">--%>
    <%--<link rel="icon" type="image/png" sizes="16x16" href="themes/one-ring/images/favicon/favicon-16x16.png">--%>

    <%--<link rel="stylesheet" type="text/css" href="/themes/calendar/STATICCUT/Calendario/css/calendar.css" />--%>
    <%--<link rel="stylesheet" type="text/css" href="/themes/calendar/STATICCUT/Calendario/css/custom_1.css" />--%>
    <script src="/themes/calendar/STATICCUT/Calendario/js/modernizr.custom.63321.js"></script>
</head>
<body>
<div class="container-fluid" id="site-wrapper">
    <!-- Codrops top bar -->
    <%--<div class="codrops-top clearfix">--%>
        <%--<a href="http://tympanus.net/Development/Stapel/"><strong>&laquo; Previous Demo: </strong>Adaptive Thumbnail Pile Effect</a>--%>
        <%--<span class="right">--%>
					<%--<a href="http://tympanus.net/codrops/?p=12416"><strong>Back to the Codrops Article</strong></a>--%>
				<%--</span>--%>
    <%--</div><!--/ Codrops top bar -->--%>
    <div class="custom-calendar-wrap custom-calendar-full">
        <div class="custom-header clearfix">
            <h2>WhatsHapp</h2>
            <h3 class="custom-month-year">
                <span id="custom-month" class="custom-month"></span>
                <span id="custom-year" class="custom-year"></span>
                <nav>
                    <span id="add-event">Add Event</span>
                    <span id="custom-prev" class="custom-prev" @click="prevMonth"></span>
                    <span id="custom-next" class="custom-next" @click="nextMonth"></span>
                    <span id="custom-current" class="custom-current" title="Got to current date" @click="currentMonth"></span>
                </nav>
            </h3>
        </div>
        <div id="calendar" class="fc-calendar-container"></div>
        <!-- Modal -->
        <% include Modals/EventModal %>
    </div>
</div><!-- /container -->
<%--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>--%>
<%--<script type="text/javascript" src="/themes/calendar/STATICCUT/Calendario/js/jquery.calendario.js"></script>--%>
<%--<script type="text/javascript" src="/themes/calendar/STATICCUT/Calendario/js/data.js"></script>--%>
<%--<script type="text/javascript" src="/themes/calendar/STATICCUT/Calendario/js/main.js"></script>--%>

</body>
<div class="clearfix"></div>
</html>