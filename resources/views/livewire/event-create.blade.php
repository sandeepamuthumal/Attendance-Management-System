<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3>Event Creation</h3>
            </div>
            <div class="card-body basic-wizard important-validation">
                <div class="stepper-horizontal" id="stepper1">
                    <div class="stepper-one stepper step editing active">
                        <div class="step-circle"><span>1</span></div>
                        <div class="step-title">Basic Info </div>
                        <div class="step-bar-left"></div>
                        <div class="step-bar-right"></div>
                    </div>
                    <div class="stepper-two step">
                        <div class="step-circle"><span>2</span></div>
                        <div class="step-title">Location</div>
                        <div class="step-bar-left"></div>
                        <div class="step-bar-right"></div>
                    </div>
                    <div class="stepper-four step">
                        <div class="step-circle"><span>3</span></div>
                        <div class="step-title">Tickets Pricing</div>
                        <div class="step-bar-left"></div>
                        <div class="step-bar-right"> </div>
                    </div>
                </div>
                <div id="msform">
                    <form class="stepper-one row g-3 needs-validation custom-input" wire:submit="submitInfo">
                        @csrf
                        <div class="col-6">
                            <label class="form-label">Event Category<span class="text-danger">*</span></label>
                            <select wire:model="event_category" class="form-select">
                                <option value="" selected hidden>Choose...</option>
                                @foreach ($event_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('event_category')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Event Manager<span class="text-danger">*</span></label>
                            <select wire:model="event_manager" class="form-select">
                                <option value="" selected hidden>Choose...</option>
                                @foreach ($event_managers as $manager)
                                    <option value="{{ $manager->id }}">
                                        {{ $manager->first_name . ' ' . $manager->last_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('event_manager')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-12">
                            <label class="col-sm-12 form-label">Title<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" wire:model="title"
                                placeholder="Enter event title">
                            <span class="text-danger">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="col-sm-12 form-label">Description</label>
                            <textarea wire:model="description" class="form-control" placeholder="Enter event description"
                                onkeyup="setDescription()"></textarea>
                        </div>
                        <div class="wizard-footer d-flex gap-2 justify-content-end">
                            <button type="submit" class="btn btn-primary">Next</button>
                            <button id="next-btn" onclick="nextStep();" hidden></button>
                        </div>
                    </form>
                    <form class="stepper-two row g-3 needs-validation custom-input" novalidate="">
                        <div class="col-md-6">
                            <label class="form-label" for="">Start Time<span class="text-danger">*</span>
                            </label>
                            <input class="form-control" wire:model="start_time" type="datetime-local" required="">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="">End Time </label>
                            <input class="form-control" wire:model="end_time" type="datetime-local" required="">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="country">Country</label>
                            <select class="single-select form-select" wire:model="country" id="country"
                                wire:change.live="loadCities">
                                <option selected="" disabled="" value="">Choose...</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="city">City</label>
                            <select class="single-select form-select" wire:model="city" id="city">
                                <option selected="" disabled="" value="">Choose...</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->city }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="">Event Location<span class="text-danger">*</span>
                            </label>
                            <input type="text" wire:model="event_location" class="form-control"
                                placeholder="Enter event location" required="">
                        </div>
                        <div class="col-md-12" style="margin-bottom: 5rem">
                            <label class="form-label" for="">Event Image </label>
                            <input type="file" wire:model="event_image" class="form-control">
                        </div>
                        <div class="wizard-footer d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-dark" onclick="backStep()"> Back</button>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                        </div>
                    </form>
                    <form class="stepper-four row g-3 needs-validation mb-5" novalidate="" >
                        <div class="col-md-6">
                            <label class="form-label" for="">Sales Start Time </label>
                            <input class="form-control" wire:model="sales_start_time" type="datetime-local"
                                required="">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="">Sales End Time </label>
                            <input class="form-control" wire:model="sales_end_time" type="datetime-local">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="">Ticket Category </label>
                            <select wire:model="ticket_category" class="form-select"
                                wire:change.live="loadTicketPrice">
                                <option value="" selected hidden>Choose...</option>
                                @foreach ($ticket_categories as $tcategory)
                                    <option value="{{ $tcategory->id }}">{{ $tcategory->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="">Ticket Price </label>
                            <input class="form-control text-end" wire:model="ticket_price" type="number">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="">Count </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="form-control text-end" wire:model="ticket_count" type="number"
                                        min="1">
                                </div>
                                <div class="col-md-6">
                                    <a class="text-primary fs-3" id="btn-add-ticket" onclick="addTicket()"><i
                                            class="bi bi-plus-circle"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label text-black text-center fw-bold fs-4" for=""> -- All
                                Tickets -- </label>
                            <div class="table-responsive">
                                <table class="table table-striped bg-primary" style="width: 100%">
                                    <tbody>
                                        <tr>
                                            <td class="alert-light-primary" style="width: 33.5%">
                                                <select wire:model="ticket_category" class="form-select"
                                                    wire:change.live="loadTicketPrice">
                                                    <option value="" selected hidden>Choose...</option>
                                                    @foreach ($ticket_categories as $tcategory)
                                                        <option value="{{ $tcategory->id }}">
                                                            {{ $tcategory->category }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="alert-light-primary">
                                                <input class="form-control text-end" type="number">
                                            </td>
                                            <td class="alert-light-primary">
                                                <input class="form-control text-end" type="number">
                                            </td>
                                            <td class="alert-light-primary">
                                                <a class="text-danger fs-3" id="btn-remove-ticket"
                                                    onclick="removeTicket()"><i class="bi bi-x-circle"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="alert-light-primary" style="width: 33.5%">
                                                <select wire:model="ticket_category" class="form-select"
                                                    wire:change.live="loadTicketPrice">
                                                    <option value="" selected hidden>Choose...</option>
                                                    @foreach ($ticket_categories as $tcategory)
                                                        <option value="{{ $tcategory->id }}">
                                                            {{ $tcategory->category }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="alert-light-primary">
                                                <input class="form-control text-end" type="number">
                                            </td>
                                            <td class="alert-light-primary">
                                                <input class="form-control text-end" type="number">
                                            </td>
                                            <td class="alert-light-primary">
                                                <a class="text-danger fs-3" id="btn-remove-ticket"
                                                    onclick="removeTicket()"><i class="bi bi-x-circle"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="wizard-footer d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-dark" onclick="backStep()"> Back</button>
                            <button type="button" class="btn btn-primary">Finish</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
