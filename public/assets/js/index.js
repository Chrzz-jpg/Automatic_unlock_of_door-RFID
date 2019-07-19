$(document).ready(function() {
    var fs = function(){
      $('#tableUsers').DataTable({
          ajax:{
              method: 'GET',
              url:'/api/logs',
              dataSrc: '',
          },
        columns: [
          { data: 'name' },
          { data: 'id' },
          { data: 'data' }
      ],
         columnDefs: [
             {targets: 1,
             className: 'dt-body-left'}
         ],
         language: {
          "sEmptyTable": "Nenhum registro encontrado",
          "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
          "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
          "sInfoFiltered": "(Filtrados de _MAX_ registros)",
          "sInfoThousands": ".",
          "sLengthMenu": " Mostrar _MENU_ resultados por página",
          "sLoadingRecords": "Carregando...",
          "sProcessing": "Processando...",
          "sZeroRecords": "Nenhum registro encontrado",
          "sSearch": "Pesquisar",
          "oPaginate": {
              "sNext": "Próximo",
              "sPrevious": "Anterior",
              "sFirst": "Primeiro",
              "sLast": "Último"
          },
          "oAria": {
              "sSortAscending": ": Ordenar colunas de forma ascendente",
              "sSortDescending": ": Ordenar colunas de forma descendente"
          }
  }
  
      });
    };
    fs();
  
  $('.dataTables_length').addClass('tabelaSelect');
  $('.dataTables_filter').addClass('pesquisa');
  $('input, search').attr("placeholder", 'Buscar');
  $('div#tableUsers_length select').addClass('custom-select custom-select-sm ');
  $('div#tableUsers_filter').css('color','#343a40');
  $('div#tableUsers_length').css('color','#343a40');
  
  });