

<div class="Modal__Data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="eventModalModalLabel">{$EventTitle}</h4>
    </div>
    <div class="modal-body">
        <div class="event-data">
            <div class="title-strip">
                <h1>{$EventTitle}</h1>
            </div>
            <div class="date-time-strip">
                <h3>Date & Time</h3>
            </div>
            <div class="image-strip">
                <% if $FindaImages %>
                    <% loop $FindaImages %><img class="img-responsive" src="$URL"><% end_loop %>
                <% else %>
                    <a href=""><img class="img-responsive" src="http://via.placeholder.com/850x450"></a>
                <% end_if %>
            </div>
            <div class="details-strip">
                <p>Details like restrcietion and ticket details</p>
            </div>
            <div class="description-strip">
                {$EventDescription}
            </div>
        </div>
    </div>
    <%--<div class="modal-footer">--%>
    <%--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--%>
    <%--<button type="button" class="btn btn-primary">Save changes</button>--%>
    <%--</div>--%>
</div>