<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/fechas.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>


<script src="js/handlebars.js"></script>
<script src="js/typeahead.bundle.min.js"></script>

<?php if (isset($scripts)): ?>
    <?php foreach ($scripts as $script): ?>
        <script type="text/javascript" src="js/<?php echo $script; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

        
<script>
    var menus = [];
    $(".panel-group > .panel .panel-body ul>li>a").each(function(i, e){
        var $a = $(this);
        menus.push({
            label: $a.text(),
            href: $a.attr('href')
        });
    });
    var bhMenus = new Bloodhound({
        datumTokenizer: function(d){ return Bloodhound.tokenizers.whitespace(d.label);},
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: menus
    });
    bhMenus.initialize();
    $('#typeahead-menu input.typeahead').typeahead({
            hint: true,
            highlight: true
        },{
        displayKey: 'label',
        source: bhMenus.ttAdapter()
    });
    $('#typeahead-menu input.typeahead').bind('typeahead:selected', function(obj, datum, name) {                
        location.href = datum.href;                
    });
</script>        