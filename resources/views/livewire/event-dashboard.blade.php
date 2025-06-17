<div class="row">

    <div class="container-fluid product-wrapper">
        <div class="product-grid">
            <div class="feature-products">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="product-sidebar" wire:ignore>
                            <div class="filter-section">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0 f-w-600">
                                            Filters
                                        </h6>
                                        <div class="light-box float-end"><a data-bs-toggle="collapse"
                                                href="#collapseProduct" title="Filter Events" role="button"
                                                aria-expanded="false" aria-controls="collapseProduct"><i
                                                    class="filter-icon show" data-feather="filter"></i><i
                                                    class="icon-close filter-close hide"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-12">
                        <form>
                            <div class="form-group m-0">
                                <input class="form-control" type="search" placeholder="Search.."
                                    wire:model.live="searchTerm" /><i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row" wire:ignore>
                    <div class="collapse" id="collapseProduct">
                        <div class="list-product-body pb-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label class="form-label">Event Category : </label>
                                            <select wire:model.live="category" id="event_category" class="form-select">
                                                <option value="" selected>All Categories</option>
                                                @foreach ($event_categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->category }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if (Auth::user()->user_types_id == 1)
                                            <div class="col-lg-3">
                                                <label class="form-label">Event Manager :</label>
                                                <select wire:model.live="manager" id="event_manager"
                                                    class="form-select">
                                                    <option value="" selected>All Managers</option>
                                                    @foreach ($event_managers as $manager)
                                                        <option value="{{ $manager->id }}">
                                                            {{ $manager->first_name . ' ' . $manager->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        @if (Auth::user()->user_types_id == 2)
                                            <div class="col-lg-3">
                                                <label class="form-label">Event Type : </label>
                                                <select wire:model.live="event_type" id="event_type" class="form-select">
                                                    <option value="" selected>All Types</option>
                                                    <option value="Open">Open</option>
                                                    <option value="Limited">Limited</option>
                                                </select>
                                            </div>
                                        @endif

                                        <div class="col-lg-3">
                                            <label class="form-label" for="">Event Date : </label>
                                            <input class="form-control" wire:model.live="date" type="date"
                                                required="">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label" for="">Event Time : </label>
                                            <input class="form-control" wire:model.live="time" type="time"
                                                required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-wrapper-grid">
                <div class="row list-collection">
                    @foreach ($events as $event)
                        <div class="col-xl-3 col-lg-3 col-sm-6">
                            <a href="{{ url('view/event', $event->id) }}">
                                <div class="card shadow" style="min-height: 502px">
                                    <div class="product-box">
                                        <div class="product-img"
                                            style="background: url('{{ asset('uploads/events/' . $event->event_image) }}')">
                                            <img class="img-fluid cardImg"
                                                src="{{ asset('uploads/events/' . $event->event_image) }}"
                                                alt="" />
                                            <div class="product-hover">
                                                <ul>
                                                    <li><a href="{{ url('view/event', $event->id) }}"><i
                                                                class="icon-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="event-details">
                                            <div class="row">
                                                <div class="col-12">
                                                    <small><i class="bi bi-calendar3"></i>
                                                        {{ \Carbon\Carbon::parse($event->event_start_time)->format('j, F Y, g:i A') }}</small>
                                                </div>
                                                <div class="col-12">
                                                    <small><i class="bi bi-geo-alt"></i> {{ $event->venue }}</small>
                                                </div>
                                            </div>
                                            <a href="{{ url('view/event', $event->id) }}" class="text-center p-2">
                                                <h4 class="fw-bold text-primary">
                                                    {{ \Illuminate\Support\Str::limit($event->title, 30) }}</h4>
                                            </a>
                                            <div class="ticket-details row">
                                                <span class="col-12">Tickets Sold: <span
                                                        class="text-danger fw-bold">{{ $event->sales_tickets_count }}</span></span>
                                                <span class="col-12">Tickets Available: <span
                                                        class="text-danger fw-bold">{{ $event->available_tickets_count }}</span></span>
                                                <span
                                                    class="text-primary col-12 text-start">{{ $event->category . ' ' }}</span>
                                                <div class="col-12 text-end">
                                                    @switch($event->status)
                                                        @case(0)
                                                            <span class="badge bg-danger">CANCELLED</span>
                                                        @break

                                                        @case(1)
                                                            <span class="badge bg-success">SUCCESS</span>
                                                        @break

                                                        @case(2)
                                                            <span class="badge bg-warning">PENDING</span>
                                                        @break

                                                        @case(3)
                                                            <span class="badge bg-primary">POSTPONED</span>
                                                        @break

                                                        @case(4)
                                                            <span class="badge bg-info">RESCHEDULED</span>
                                                        @break

                                                        @case(5)
                                                            <span class="badge bg-dark">CLOSED</span>
                                                        @break

                                                        @default
                                                    @endswitch
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-12 mb-3">
                {{ $events->links('livewire.livewire-pagination') }}
            </div>
        </div>
    </div>
</div>
