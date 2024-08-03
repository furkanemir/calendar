<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Takvim</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tui-calendar/5.14.0/tui-calendar.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>
<header class="header">
    <nav class="navbar">
      <div>
          <button class="button is-rounded today btn btn-primary">Bugün</button>
          <button class="button is-rounded prev btn btn-secondary">Geri</button>
          <button class="button is-rounded next btn btn-secondary">İleri</button>
      </div>
        <div>
            <select id="userFilter" class="form-control">
                <option value="all">Tüm Kullanıcılar</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <span class="navbar--range"></span>
            <a href="/download-pdf" ><button class="button is-rounded today btn btn-danger">PDF olarak indir</button></a>
        </div>
    </nav>
</header>
<div id="calendar"></div>

<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="eventForm">
                <input type="hidden" id="eventId" name="event_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Etkinlik Oluştur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_id">Kullanıcı:</label>
                        <select class="form-control" id="user_id" name="user_id" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Başlık:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Açıklama:</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="start">Başlangıç Tarihi:</label>
                        <input type="datetime-local" class="form-control" id="start" name="start" required>
                    </div>
                    <div class="form-group">
                        <label for="end">Bitiş Tarihi:</label>
                        <input type="datetime-local" class="form-control" id="end" name="end" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailsModalLabel">Etkinlik Detayları</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 id="eventDetailsTitle"></h5>
                <p id="eventDetailsDescription"></p>
                <p id="eventDetailsUserName"></p>
                <p><strong>Başlangıç:</strong> <span id="eventDetailsStart"></span></p>
                <p><strong>Bitiş:</strong> <span id="eventDetailsEnd"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="editEventButton" class="btn btn-primary">Güncelle</button>
                <button type="button" id="deleteEventButton" class="btn btn-danger">Sil</button>
            </div>
        </div>
    </div>
</div>

<script>
    const events = @json($events);
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
