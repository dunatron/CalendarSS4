<div class="logo-wrapper client-logo">
    <a href="$AbsoluteBaseURL">
        <%--<% with $SiteConfig.ClientLogo.Fill(50,50) %>--%>
            <%--<img src="$URL"--%>
                 <%--class="img-responsive">--%>
        <%--<% end_with %>--%>
        <% with $SiteConfig %>
            <% if $ClientLogo %>
            <% else %>
                <a href="https://placeholder.com"><img src="http://via.placeholder.com/200x50"></a>
            <% end_if %>
        <% end_with %>
    </a>
</div>