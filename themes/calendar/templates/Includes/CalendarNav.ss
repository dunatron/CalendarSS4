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
    <%--<h2>WhatsHapp</h2>--%>

    <div class="logo__wrapper">
        <% include HappLogo %>
    </div>
    <div class="date__wrapper">
        <span id="custom-prev" class="custom-prev" @click="prevMonth"></span>
        <span id="custom-month" class="custom-month"></span>
        <span id="custom-year" class="custom-year"></span>
        <span id="custom-next" class="custom-next" @click="nextMonth"></span>
    </div>
    <div class="controls__wrapper">
        <span id="AddEventBtn">Add Event</span>
        <span id="FilterBtn">Filter</span>
        <span id="SearchBtn">Search</span>
        <%--<span id="custom-current" class="custom-current" title="Got to current date" @click="currentMonth"></span>--%>
    </div>
</div>