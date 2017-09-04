<%--<div class="custom-header clearfix">--%>
    <%--<h2>WhatsHapp</h2>--%>
    <%--<% include HappLogo %>--%>
    <%--<h3 class="custom-month-year">--%>
        <%--<span id="custom-month" class="custom-month"></span>--%>
        <%--<span id="custom-year" class="custom-year"></span>--%>
        <%--<nav>--%>
            <%--<span id="add-event">Add Event</span>--%>
            <%--<span id="custom-prev" class="custom-prev" @click="prevMonth"></span>--%>
            <%--<span id="custom-next" class="custom-next" @click="nextMonth"></span>--%>
            <%--<span id="custom-current" class="custom-current" title="Got to current date" @click="currentMonth"></span>--%>
        <%--</nav>--%>
    <%--</h3>--%>
<%--</div>--%>

<div class="custom-header clearfix">
    <div class="logo__wrapper">
        <% include HappLogo %>
        <a href="https://placeholder.com"><img src="http://via.placeholder.com/200x50"></a>
    </div>
    <div class="date__wrapper">
        <span id="custom-prev" class="custom-prev" @click="prevMonth"></span>
        <div class="month__year__wrap">
            <span id="custom-month" class="custom-month"></span>
            <span id="custom-year" class="custom-year"></span>
        </div>
        <span id="custom-next" class="custom-next" @click="nextMonth"></span>
    </div>
    <div class="controls__wrapper">
        <span id="AddEventBtn" data-toggle="modal" data-target="#addEventModal">Add {$getAddEventSVG}</span>
        <span id="FilterBtn" data-toggle="modal" data-target="#filterModal">Filter {$getFilterSVG}</span>
        <span id="SearchBtn" data-toggle="modal" data-target="#searchModal">Search {$getSearchSVG}</span>
        <span id="custom-current" class="custom-current" title="Got to current date" @click="currentMonth">{$getLoopSVG}</span>
    </div>
</div>