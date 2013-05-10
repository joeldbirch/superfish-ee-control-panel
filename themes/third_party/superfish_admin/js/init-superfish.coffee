( ($) ->

  superfishify =
    init: ->
      @menu = $('#navigationTabs')
      @top_lis = @menu.children('.parent')
      @other_lis = @menu.find('li').not(@top_lis)
      @links = @menu.find('a')

      @unbind_ee_handlers()
      @init_superfish()

    unbind_ee_handlers: ->
      @menu.off('mouseleave')
      @top_lis.off('mouseenter')
      @other_lis.off('mouseenter mouseleave')
      #shame ee uses # for hrefs when there are relevant pages they could link to
      #toggle_cpnav retails click handler for Zoo Flexible Admin
      @links.not('#toggle_cpnav').off('click').filter('[href="#"]').on('click.superfish', false)

    init_superfish: ->
      @menu.superfish
        hoverClass: 'active'
        cssArrows: false
        speed: 200
        onHide: ->
          #not sure why the subs need extra help to hide
          this.hide()

  $ ->
    superfishify.init()

)(jQuery)