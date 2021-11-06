<?php
# Шаблон представления содержащий js верстку
?>

<head>          
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>       
</head>
<div id="live_data"></div>

<script>
    $(document).ready(function () {

        function fetch_data()
        {
            $.ajax({
                url: "/wiki-api/index/menu",
               
                method: "POST",
                success: function (data) {
                    $('#live_data').html(data);
                    setKeydownmyForm()
                }
            });
        }
        fetch_data();


        $(document).on('click', '#wiki', function () {

            $.ajax({
                url: "/wiki-api/index/wiki",
                method: "POST",

                data: $('#wiki-form').serialize(),
                dataType: "text",
                success: function (data)
                {
                    alert(data);                    
                }
            })
        })




        $(document).on('click', '#wiki-search', function () {

            $.ajax({
                url: "/wiki-api/index/menu",
                method: "POST",

                data: $('#wiki-form-search').serialize(),
                dataType: "text",
                success: function (data)
                {
                    $('#live_data').html(data);
                }
            })
        })




        $(document).on('click', '#btn_1', function () {

            var tr = this.closest('tr');
            var heading = $('.heading', tr).val();

            $.ajax({
                url: "/wiki-api/index/menu",
                method: "POST",
                data: {heading: heading},
                dataType: "text",
                success: function (data)
                { 
                    $('#live_data').html(data);
                }
            })
        })

    });
</script>