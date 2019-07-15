<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Advanced Search Form
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">

        <!--begin: Search Form -->
        <form class="m-form m-form--fit m--margin-bottom-20">
            <div class="row m--margin-bottom-20">
                <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                    <label>Search:</label>
                </div>
                <div class="col-lg-6 m--margin-bottom-10-tablet-and-mobile">
                    <div class="input-daterange input-group" id="m_datepicker">
                        <input type="text" class="form-control m-input" name="start" placeholder="From" data-col-index="5" />
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                        </div>
                        <input type="text" class="form-control m-input" name="start" placeholder="From" data-col-index="5" />
                    </div>
                </div>
                {{--  <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                    <div class="input-daterange input-group" id="m_datepicker">
                        <input type="text" class="form-control m-input" name="start" placeholder="From" data-col-index="5" />
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                        </div>
                    </div>
                </div>  --}}
                <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-brand m-btn m-btn--icon" id="m_search">
                                <span>
                                <i class="la la-search"></i>
                                <span>Search</span>
                                </span>
                            </button> &nbsp;&nbsp;
                            <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset">
                                <span>
                                <i class="la la-close"></i>
                                <span>Reset</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
            <thead>
                <tr>
                    <th>Record ID</th>
                    <th>Order ID</th>
                    <th>Country</th>
                    <th>Ship City</th>
                    <th>Company Agent</th>
                    <th>Ship Date</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Record ID</th>
                    <th>Order ID</th>
                    <th>Country</th>
                    <th>Ship City</th>
                    <th>Company Agent</th>
                    <th>Ship Date</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>