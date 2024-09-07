@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Dashboard Header -->
        <div class="mb-4">
            <h1 class="text-dark">Client</h1>
        </div>

        <!-- Clients Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <!-- Add a larger margin-bottom to push the card further down -->
                <div class="card mb-5">
                    <div class="card-header bg-primary text-white shadow-sm p-3">
                        <h3 class="card-title">Client</h3>
                    </div>

                    <div class="card-body">
                        <!-- Table starts here -->
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Parent</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>PO Box</th>
                                        <th>Tel</th>
                                        <th>Fax</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Parent A</td>
                                        <td>Client One</td>
                                        <td>123 Main St, City</td>
                                        <td>12345</td>
                                        <td>(123) 456-7890</td>
                                        <td>(123) 456-7891</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Parent B</td>
                                        <td>Client Two</td>
                                        <td>456 Elm St, City</td>
                                        <td>67890</td>
                                        <td>(098) 765-4321</td>
                                        <td>(098) 765-4322</td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Table ends here -->
                    </div>
                    
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-secondary">Showing <span>1</span> to <span>2</span> of <span>2</span> entries</p>
                        <ul class="pagination m-0 ms-auto">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                                    prev
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    next <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
