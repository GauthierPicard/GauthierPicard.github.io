function parseRSS(url, container) {
  //feed to parse
  var feed = url;
  
  $.ajax(feed, {
    accepts:{
      xml:"application/rss+xml"
    },
    dataType:"xml",
    success:function(data) {
      var thehtml = "<dt>";
      $(data).find("item").each(function (index, value) { // or "item" or whatever suits your feed
        if (index < 20) {
        var el = $(this);
        var date = new Date(el.find("pubDate").text());
        var strdate = date.getDay() + "/" + date.getMonth() + "/" + date.getYear();
        thehtml += "<b><a class=\"headnews\" href=\"" + el.find("link").text() + "\">";
        thehtml += capitaliseFirstLetter(el.find("title").text()) + "</a></b> &nbsp;<span class=\"datenews\" style=\"\">";
        thehtml += " <b>[<i>" + date.toLocaleDateString() + "</i>]</b></span></dt>";
        thehtml += "<dd class=\"news\">" + el.find("description").text() + "</dd>\n";
      }
      });
      thehtml += "</dl>\n";
      $(container).append(thehtml);
    } 
  });
  
}

/**
 * Capitalizes the first letter of any string variable
 * source: http://stackoverflow.com/a/1026087/477958
 */
function capitaliseFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}