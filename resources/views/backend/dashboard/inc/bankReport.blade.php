<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Advanced Search Form
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="#" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
      <i class="la la-cart-plus"></i>
      <span>New Record</span>
                        </span>
                    </a>
                </li>
                <li class="m-portlet__nav-item"></li>
                <li class="m-portlet__nav-item">
                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                        <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                            <i class="la la-ellipsis-h m--font-brand"></i>
                        </a>
                        <div class="m-dropdown__wrapper">
                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                            <div class="m-dropdown__inner">
                                <div class="m-dropdown__body">
                                    <div class="m-dropdown__content">
                                        <ul class="m-nav">
                                            <li class="m-nav__section m-nav__section--first">
                                                <span class="m-nav__section-text">Quick Actions</span>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                    <span class="m-nav__link-text">Create Post</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                    <span class="m-nav__link-text">Send Messages</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-multimedia-2"></i>
                                                    <span class="m-nav__link-text">Upload File</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__section">
                                                <span class="m-nav__section-text">Useful Links</span>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                    <span class="m-nav__link-text">FAQ</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                    <span class="m-nav__link-text">Support</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__separator m-nav__separator--fit m--hide">
                                            </li>
                                            <li class="m-nav__item m--hide">
                                                <a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="m-portlet__body">

        <!--begin: Search Form -->
        <form class="m-form m-form--fit m--margin-bottom-20">
            <div class="row m--margin-bottom-20">
                <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                    <label>RecordID:</label>
                    <input type="text" class="form-control m-input" placeholder="E.g: 4590" data-col-index="0">
                </div>
                <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                    <label>OrderID:</label>
                    <input type="text" class="form-control m-input" placeholder="E.g: 37000-300" data-col-index="1">
                </div>
                <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                    <label>Country:</label>
                    <select class="form-control m-input" data-col-index="2">
    <option value="">Select</option>
  </select>
                </div>
                <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                    <label>Agent:</label>
                    <input type="text" class="form-control m-input" placeholder="Agent ID or name" data-col-index="4">
                </div>
            </div>
            <div class="row m--margin-bottom-20">
                <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                    <label>Ship Date:</label>
                    <div class="input-daterange input-group" id="m_datepicker">
                        <input type="text" class="form-control m-input" name="start" placeholder="From" data-col-index="5" />
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                        </div>
                        <input type="text" class="form-control m-input" name="end" placeholder="To" data-col-index="5" />
                    </div>
                </div>
                <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                    <label>Status:</label>
                    <select class="form-control m-input" data-col-index="6">
    <option value="">Select</option>
  </select>
                </div>
                <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                    <label>Type:</label>
                    <select class="form-control m-input" data-col-index="7">
    <option value="">Select</option>
  </select>
                </div>
            </div>
            <div class="m-separator m-separator--md m-separator--dashed"></div>
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