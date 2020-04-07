// $(document).ready(function() {
//     $('#_table').DataTable();
// } );

// $.ajax({
//     type: 'GET',
//     url: '/php/get_orders.php',
//     dataType: 'json',
//     success: function(data){
//         $('body').append(data);

//         if(data.length > 0){
            
//             var html = '';

//             $(data).each(function(i, row){
//                 html += '<tr>';
//                 html += "<td>"+row.external_number+"</td>";
//                 html += "<td>"+row.order_id+"</td>";
//                 html += "<td>"+row.name+"</td>";
//                 html += "<td>"+row.phone+"</td>";
//                 html += "<td>"+row.status+"</td>";
//                 html += "<td>"+row.db_status+"</td>";
//                 html += "<td>"+row.updated_at+"</td>";
//                 html += '</tr>';
//             });
            
//             $('#_table tbody').html(html);
       
//         }else{

//         }
//     },
//     error: function(err){
//         console.log(err)
//     }
// })



