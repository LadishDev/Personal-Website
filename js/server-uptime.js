$(document).ready(function() {
    // Make an AJAX request to retrieve server status
    $.ajax({
        url: "/server-status?auto",
        dataType: "text",
        success: function(data) {
            // Parse the response and extract relevant information (e.g., uptime)
            var uptime = data.match(/Uptime: (.+)$/m)[1];

            // Update the HTML content with the server uptime
            $("#server-status").html("<p>Server Uptime: " + uptime + "</p>");
        },
        error: function() {
            // Handle errors, if any
            $("#server-status").html("<p>Error retrieving server status.</p>");
        }
    });
});
