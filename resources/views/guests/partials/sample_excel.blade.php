<a href="#" class="" data-toggle="modal" data-target="#sampleExcel">
    <i class="fa fa-file-excel-o" aria-hidden="true"></i> View sample excel format
    | <a href="{!! asset('sample_guest_excel.xlsx') !!}" download>
        <i class="fa fa-download" aria-hidden="true"></i> Download a sample excel file
    </a>
</a>

<div id="sampleExcel" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> Sample upload excel file (.xlsx)
                </h4>
            </div>

            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Guest Group</th>
                        <th>Khmer Name</th>
                        <th>English Name</th>
                        <th>Phone Number</th>
                        <th>Print Name</th>
                        <th>Address</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>RUPP</td>
                            <td>សុខ សាន</td>
                            <td>Sok San</td>
                            <td>012 121212</td>
                            <td>លោក សុខសាន និង ភរិយា</td>
                            <td>Phnom Penh</td>
                        </tr>
                        <tr>
                            <td>RUPP</td>
                            <td>ហុង ហេង</td>
                            <td>Hong Heng</td>
                            <td>013 131313</td>
                            <td>លោក ហុង ហេង</td>
                            <td>Kandal</td>
                        </tr>
                    </tbody>
                </table>

                <p>
                    <strong>Note:</strong> You have to name the excel header exactly the same as above sample,
                    otherwise, no record will be imported. You have to
                    input <strong>English Name</strong> or <strong>Khmer Name</strong>;
                    otherwise, system will not import that record.
                </p>
                <p>
                    <a href="{!! asset('sample_guest_excel.xlsx') !!}" download>
                        <i class="fa fa-download" aria-hidden="true"></i> Download a sample excel file
                    </a>
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>