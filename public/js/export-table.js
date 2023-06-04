function exportExcel(){
    $("#myTable").table2excel({
        // exclude CSS class
        exclude: ".noExl",
        name: "Donnees",
        filename: "donnee-details", //do not include extension
        fileext: ".xls", // file extension
        preserveColors:true,
        exclude_img:false,
        exclude_links:false,
        exclude_inputs:false

    });
}

function exportPDF() {
    html2canvas($('#myTable')[0], {
        onrendered: function (canvas) {
            var data = canvas.toDataURL();
            var docDefinition = {
                content: [{
                    image: data,
                    width: 500
                }]
            };
            pdfMake.createPdf(docDefinition).download("donnee-details.pdf");
        }
    });
}

function exportCSV() {
    $("#myTable").table2csv({
        filename:'donnees-details.csv',
        separator:',',
        newline:'\n',
        quoteFields:true,
        excludeColumns:'',
        excludeRows:'',
        trimContent:true
    });
}
