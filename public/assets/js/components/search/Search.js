export default {
  name: 'Search',
  data: () => {
    return {
      description: '',
      placeholder: 'Type in a character name, skill, zone, mob. Search also accepts the same filters as ingame.'
    }
  },
  template: `
    <div class="page">
      <h3>Search</h3>
      <div class="form">
        <table cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td style="padding:0 10px 0 0;">
              <input type="searchquery"
                     id="searchquery"
                     style="width:100%;"
                     :placeholder="placeholder">
            </td>
            <td width="2%">
              <input type="button" value="Search" />
            </td>
          </tr>
        </table>
      </div>
      <div style="height:30px;"></div>
      <div id="searchresults">
        {{ description }}
      </div>
    </div>
    `
}