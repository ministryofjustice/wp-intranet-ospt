<div class="search-block">
  <span class="date"><script type="text/javascript" src="scripts/date.js"></script></span>
  <div class="search-intranet" id="int">
    <!-- searchbox for intranet and peopleFinder -->
    <form action="/" method="get" name="query" id="query">
      <label for="s" class="offset">Search:</label> <input id="s" name="s" type="text" class="searchbox" size="28" /> <input id="submit" type="submit" value="Go" class="searchbutton" title="Search" /> <input type="hidden" id="filter" name="filter" value="0" /><br />
      Search: <input name="searchtype" type="radio" id="intranet" value="intranet" checked="checked" /> <label for="intranet">intranet</label> &nbsp; <input name="searchtype" type="radio" id="people" value="peoplefinder" /> <label for="people">peopleFinder</label>
    </form>
  </div>
  <div class="search-none" id="pf">
    <form action="http://intranet-applications.dca.gsi.gov.uk/peopleFinder/UserSearch2.do" method="get" name="searchform" id="searchform">
      <label for="forename" class="offset">Forename</label> <input id="forename" name="forename" type="text" class="searchbox" size="10" value="First name" /> <label for="surname" class="offset">Surname</label> <input id="surname" name="surname" type="text" class="searchbox" size="12" value="Last name" /> <input type="submit" class="searchbutton" id="submit1" title="Search" value="Go" /><br />
      Search: <input name="searchtype1" type="radio" id="intranet1" value="intranet" /> <label for="intranet1">intranet</label> &nbsp; <input name="searchtype1" type="radio" id="people1" value="peoplefinder" checked="checked" /> <label for="people1">peopleFinder</label>
    </form>
  </div>
</div>
