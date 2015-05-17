$(document).ready(function() {

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });


    //one function to load in titles and data after typing
    $(function () {

        $( "#bookreview_bookbundle_book_title" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "https://www.googleapis.com/books/v1/volumes",
                    type: "GET",
                    dataType: "json",
                    data: {
                       q: request.term,
                       maxResults: 20,
                       printType: "books"
                    },
                    success: function( data ) {
                        var bookTitles = [];

                        for (i=0; i <data.items.length; i++){
                            bookTitles[i] = data.items[i].volumeInfo.title;
                        }

                        response (bookTitles);
                    },
                    error: function(){
                        alert("Suggestions could not be loaded. Please try again!");
                    }
                });
            },
            select: function (){
                var query = $( "#bookreview_bookbundle_book_title").val();

                $.ajax({
                    url: "https://www.googleapis.com/books/v1/volumes",
                    type: "GET",
                    dataType: "json",
                    data: {
                        q: query,
                        maxResults: 1,
                        printType: "books"
                    },
                    success: function( data ){
                        $("#bookreview_bookbundle_book_genre").val(data.items[0].volumeInfo.categories[0]);
                        $("#bookreview_bookbundle_book_publisher").val(data.items[0].volumeInfo.publisher);
                        $("#bookreview_bookbundle_book_summary").val(data.items[0].searchInfo.textSnippet);
                        $("#bookreview_bookbundle_book_author").val(data.items[0].volumeInfo.authors[0]);
                    },
                    error: function(){
                        alert("Book information could not be loaded. Please try again!");
                    }
                });
            },
            minLength: 3
        });

        $(".ui-helper-hidden-accessible").hide();

    });

});