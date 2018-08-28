$(function () {
  // Initialize clicks
  events.init()
})

/* test
 * - Just a few testing functions
 */
var test =
  {
    editCharacter: function () {
      character.go({uid: '21828', table: 'chars', type: 'character', action: 'edit'})

    }
  }

/* events
 * - Initializes onclick, keyup, etc type events
 */
var events =
  {
    init: function () {
      // Tooltips
      $(document).tooltip(
        {
          // Show / Hide
          show: null,
          hide: null,

          track: true,

          // Position
          position:
            {
              my: 'center bottom-12',
              at: 'center top',
            }
        })

      // Search option
      $('.search-option').unbind('click')
      $('.search-option').click(function () { search.edit($(this)) })
    },
  }

/* pages
 * - handles loading ajax pages
 */
var pages =
  {
    list:
      {
        // Content related
        character: 'character.php'
      },

    go: function (page, data) {
      // Get the file
      var file = pages.list[page]

      // If file exists, ajax
      if (file) {
        ajax.go(
          {
            url: file,
            data: data,
            success: pages.success,
            error: pages.error,
          })
      }
    },

    success: function (data) {
      // Set page
      $('#ajax').html(data)

      // Reregister events
      events.init()
    },

    error: function (data, status, thrown) {
      console.log('---ajax error---')
      console.log(data)
      console.log(status)
      console.log(thrown)
    }
  }

/* character
 * - handles character stuff
 */
var character =
  {
    go: function (dataobj) {
      // Load in
      pages.go(dataobj.type, dataobj)
    }
  }

/* ajax
 * - CORE AJAX OBJECT, if everything runs through here very easy
 * to monitor and track call issues and swap out params.
 */
var ajax =
  {
    // Main ajax call, everything runs through this method. Callback is optional, will be fored on both success and error.
    go: function (options, callback) {
      var URL = options.url
      var Type = options.type       // get or post
      var Content = options.content     // Content type, eg: content: "application/json"
      var Data = options.data       // Obj: { x: x, y: y }
      var Cache = options.cache      // Cache or not
      var Success = options.success
      var Error = options.error
      var Async = options.async
      var DType = options.datatype

      // If no file set, return false
      if (!URL) { return false }
      if (!Type) { Type = 'GET'} else { Type = Type.toUpperCase() }
      if (!Cache) { Cache = true }
      if (!Async) { Async = false }
      if (!Content) { Content = 'application/x-www-form-urlencoded; charset=UTF-8' }
      if (!DType) { DType = 'html' }

      $.ajax({

        url: URL,
        data: Data,
        type: Type,
        cache: Cache,
        async: Async,
        contentType: Content,
        dataType: DType,

        success: function (data) {
          if (Success) { Success(data) }
          if (callback) {callback()}
        },
        error: function (data, status, thrown) {
          if (Error) {
            Error({
              data: [data, status, thrown],
              msg: 'Error occured'
            })
          }
          if (callback) {callback()}
        },

      })
    }
  }