window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }

    const datatablesSimple1 = document.getElementById('datatablesSimple1');
    if (datatablesSimple1) {
        new simpleDatatables.DataTable(datatablesSimple1,{
            searchable:true,
            fixedHeight: false,
            fixedColumns: true,
            sortable:true,
            paging:true,
            perPage:5,
            firstLast:true,
        });
    }

    const datatablesSimple2 = document.getElementById('datatablesSimple2');
    if (datatablesSimple2) {
        new simpleDatatables.DataTable(datatablesSimple2,{
            searchable:true,
            fixedHeight: false,
            fixedColumns: true,
            sortable:true,
            paging:true,
            perPage:10,
            firstLast:true,

            ajax:"data.json"
        });

        setInterval( function () {
            datatablesSimple2.ajax.reload();
        }, 30000 );
    }

});