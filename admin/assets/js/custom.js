let ajaxURL =  $("#ajaxURL").val();
console.log(ajaxURL)
$(document).ready(function() {
    $('#sortby').change(function() {
        console.log('11111')
        var sortBy = $(this).val();
        if (sortBy == 'name') {
            sortByName();
        } else if (sortBy == 'score') {
            sortByScore();
        }
    });
    $(document).on('keyup', "#keyword", function(){
        let keyword = $(this).val();
        $.ajax({
            url: ajaxURL + 'trainingClass.php', 
            type: 'POST',
            data: {
                keyword: keyword,
                action:'search_keyword_emp_list'
            },
            success: function(response) {
                // Handle success response here
                console.log(response);
                if(response){
                    $('#scoreTable tbody').html(response);
                }

            },
            error: function(xhr, status, error) {
                // Handle error here
                console.error(xhr.responseText);
            }
        });

    });
    function sortByName() {
        var rows = $('#scoreTable tbody').find('tr').get();
        rows.sort(function(a, b) {
            var nameA = $(a).data('name').toUpperCase();
            var nameB = $(b).data('name').toUpperCase();
            return (nameA < nameB) ? -1 : (nameA > nameB) ? 1 : 0;
        });
        $.each(rows, function(index, row) {
            $('#scoreTable').append(row);
        });
    }
    function sortByScore() {
        console.log('4444')
        var rows = $('#scoreTable tbody').find('tr').get();
        rows.sort(function(a, b) {
            var scoreA = $(a).data('score');
            var scoreB = $(b).data('score');

            // Check if scoreA or scoreB is "N/A"
            if (scoreA === "N/A" && scoreB === "N/A") {
                return 0;
            } else if (scoreA === "N/A") {
                return 1; // Move "N/A" to the bottom
            } else if (scoreB === "N/A") {
                return -1; // Move "N/A" to the bottom
            }

            scoreA = parseFloat(scoreA);
            scoreB = parseFloat(scoreB);
            return scoreB - scoreA;
        });
        $.each(rows, function(index, row) {
            $('#scoreTable').append(row);
        });
    }


});
