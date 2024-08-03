import './bootstrap';
import Calendar from 'tui-calendar';
import 'tui-calendar/dist/tui-calendar.css';
import axios from 'axios';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.css';

const calendar = new Calendar('#calendar', {
    defaultView: 'month',
    taskView: true,
    scheduleView: true,
    theme: {
        'common.border': '1px solid #ddd'
    },
});

const eventList = events.map(event => ({
    id: event.id,
    title: event.title,
    body:event.description,
    start: event.start,
    end: event.end,
    category: 'time',
}));

calendar.createSchedules(eventList);

const monthNames = [
    'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran',
    'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'
];

const updateCalendarRange = () => {
    const rangeElement = document.querySelector('.navbar--range');
    const currentMonth = calendar.getDate().getMonth();
    const currentYear = calendar.getDate().getFullYear();
    rangeElement.textContent = monthNames[currentMonth] + ' ' + currentYear;
};

document.querySelector('.today').addEventListener('click', () => {
    calendar.today();
    updateCalendarRange();
});

document.querySelector('.prev').addEventListener('click', () => {
    calendar.prev();
    updateCalendarRange();
});

document.querySelector('.next').addEventListener('click', () => {
    calendar.next();
    updateCalendarRange();
});

flatpickr("#start", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
});

flatpickr("#end", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
});
calendar.on('beforeCreateSchedule', (event) => {
    $('#eventModal').modal('show');

    const startDate = new Date(event.start);
    const endDate = new Date(event.end);

    flatpickr("#start", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        defaultDate: startDate,
    });

    flatpickr("#end", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        defaultDate: endDate,
    });

});
document.getElementById('eventForm').onsubmit = function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const eventId = formData.get('event_id');

    const data = {
        user_id: formData.get('user_id'),
        title: formData.get('title'),
        description: formData.get('description'),
        start: formData.get('start'),
        end: formData.get('end')
    };

    if (eventId) {
        axios.put(`/events/${eventId}`, data)
            .then(response => {
                if (response.data.status === 'success') {
                    const updatedEvent = response.data.event;
                    calendar.updateSchedule(eventId, {
                        id: updatedEvent.id,
                        description:updatedEvent.description,
                        title: updatedEvent.title,
                        start: updatedEvent.start,
                        end: updatedEvent.end,
                        category: 'time',
                    });
                    $('#eventModal').modal('hide');
                }
            })
            .catch(error => {
                console.error('Error updating event:', error);
            });
    } else {
        axios.post('/events', data)
            .then(response => {
                if (response.data.status === 'success') {
                    const newEvent = response.data.event;
                    calendar.createSchedules([{
                        id: newEvent.id,
                        title: newEvent.title,
                        start: newEvent.start,
                        end: newEvent.end,
                        category: 'time',
                    }]);
                    $('#eventModal').modal('hide');
                }
            })
            .catch(error => {
                console.error('Error creating event:', error);
            });
    }
    location.reload();
};

calendar.on('clickSchedule', (event) => {
    const { schedule } = event;
    $('#eventDetailsModal').modal('show');
    document.getElementById('eventDetailsTitle').textContent = schedule.title;
    document.getElementById('eventDetailsDescription').textContent = schedule.body ? schedule.body : 'Yok';
    document.getElementById('eventDetailsStart').textContent = new Date(schedule.start).toLocaleString();
    document.getElementById('eventDetailsEnd').textContent = new Date(schedule.end).toLocaleString();

    document.getElementById('editEventButton').onclick = () => {
        $('#eventDetailsModal').modal('hide');
        $('#eventModal').modal('show');
        document.getElementById('eventId').value = schedule.id;
        document.getElementById('title').value = schedule.title;
        document.getElementById('description').value = schedule.body || '';

        flatpickr("#start", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            defaultDate: new Date(schedule.start),
        });

        flatpickr("#end", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            defaultDate: new Date(schedule.end),
        });

        document.getElementById('deleteEventButton').style.display = 'inline';
    };

    document.getElementById('deleteEventButton').onclick = () => {
        if (confirm('Bu etkinliği silmek istediğinizden emin misiniz?')) {
            axios.delete(`/events/${schedule.id}`)
                .then(response => {
                    if (response.data.status === 'success') {
                        calendar.deleteSchedule(schedule.id);
                        $('#eventDetailsModal').modal('hide');
                    }
                })
                .catch(error => {
                    console.error('Error deleting event:', error);
                });
        }
        location.reload();
    };
});

document.getElementById('userFilter').addEventListener('change', function() {
    const userId = this.value;
    filterCalendarByUser(userId);
});

function filterCalendarByUser(userId) {
    axios.get('/events', {
        params: {
            user_id: userId
        }
    })
        .then(response => {
            const events = response.data;
            const filteredEvents = events.map(event => ({
                id: event.id,
                title: event.title,
                body: event.description,
                start: event.start,
                end: event.end,
                category: 'time',
            }));
            calendar.clear();
            calendar.createSchedules(filteredEvents);
        })
        .catch(error => {
            console.error('Error fetching events:', error);
        });
}
updateCalendarRange();
