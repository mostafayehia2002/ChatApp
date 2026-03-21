<!-- Sidebar: Contacts -->
<div class="col-md-3 border-end p-0" style="height: 90vh; overflow-y: auto; font-size: 14px;">

    <div class="bg-white p-2 px-3 d-flex justify-content-between align-items-center border-bottom">
        <strong class="text-muted">Conversations</strong>

        <button class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center"
                data-bs-toggle="modal"
                data-bs-target="#addContactModal"
                style="width: 34px; height: 34px;">
            <i class="fas fa-user-plus"></i>
        </button>
    </div>

    <!-- search -->
    <div class="px-3 pt-3 pb-2">
        <form class="position-relative">
            <input type="text"
                   class="form-control form-control-sm rounded-pill ps-4 pe-5"
                   placeholder=""
                   id="contactsSearchInput">

            <!-- search icon -->
            <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

            <!-- button -->
            <button type="submit"
                    class="btn btn-sm btn-primary position-absolute top-50 end-0 translate-middle-y me-1 rounded-circle"
                    style="width: 30px; height: 30px;">
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>
    <!-- Example contacts -->
    <div id="conversions">
        <a href="" class="text-decoration-none text-dark" data-id="1">
            <div class="p-2 px-3 border-bottom d-flex align-items-center">

                <!-- avatar -->
                <img src="https://i.pravatar.cc/40?img=1"
                     class="rounded-circle me-2"
                     style="width: 40px; height: 40px; object-fit: cover;">

                <!-- name + last message -->
                <div class="flex-grow-1 overflow-hidden">
                    <div class="fw-bold text-truncate">
                        Mostafa Yehia
                    </div>

                    <div class="text-muted small text-truncate">
                        last message preview goes here...
                    </div>
                </div>

                <!-- right side -->
                <div class="text-end ms-2 d-flex flex-column align-items-end">

                    <!-- time -->
                    <span class="text-muted small">  12:30 PM </span>

                    <!-- unread count -->
                    <span class="badge bg-success mt-1">3</span>

                </div>
            </div>
        </a>

        <a href="" class="text-decoration-none text-dark" data-id="2">
            <div class="p-2 px-3 border-bottom d-flex align-items-center">

                <!-- avatar -->
                <img src="https://i.pravatar.cc/40?img=1"
                     class="rounded-circle me-2"
                     style="width: 40px; height: 40px; object-fit: cover;">

                <!-- name + last message -->
                <div class="flex-grow-1 overflow-hidden">
                    <div class="fw-bold text-truncate">
                        Ahmed
                    </div>

                    <div class="text-muted small text-truncate">
                        last message preview goes here...
                    </div>
                </div>

                <!-- right side -->
                <div class="text-end ms-2 d-flex flex-column align-items-end">
                    <!-- time -->
                    <span class="text-muted small">12:30 PM</span>
                    <!-- unread count -->
                    <span class="badge bg-success mt-1">1</span>
                </div>
            </div>
        </a>


    </div>
</div>

<!-- Add Contact Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContactModalLabel">New Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addContactForm" action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="contactEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="contactEmail" placeholder="Enter email"
                               name="email">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message here</label>
                        <input type="text" class="form-control" id="message" placeholder="Say Hello"
                               name="message" value="Say Hello">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
