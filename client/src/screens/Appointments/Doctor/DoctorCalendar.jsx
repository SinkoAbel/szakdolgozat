import { Calendar, momentLocalizer } from "react-big-calendar";
import 'react-big-calendar/lib/css/react-big-calendar.css';
import moment from "moment";
import axios from "../../../config/axios";
import { useEffect, useState } from "react";
import { useSelector } from "react-redux";

const DoctorCalendar = () => {
    const [calendarEvents, setCalendarEvents] = useState([]);

    const {
        token
    } = useSelector((state) => state.authentication);

    const fetchData = async () => {
        await axios.get('/api/appointments', {
            headers: {
                Authorization: token
            }
        }).then((response) => {
            const eventsObject = response.data.map((event) => ({
                title: (event.booked ? 'Foglalt' : 'Szabad') + ' időpont',
                start: moment(event.date + 'T' + event.start_time).toDate(),
                end: moment(event.date + 'T' + event.end_time).toDate()
            }));
            setCalendarEvents(eventsObject);
        }).catch((err) => {
            console.log(err);
        });
    }

    useEffect(() => {
        fetchData();
    }, []);

    const localizer = momentLocalizer(moment);

    return (
        <>
            <div>
                <Calendar
                    localizer={localizer}
                    events={calendarEvents}
                    startAccessor="start"
                    endAccessor="end"
                    style={{height: '100vh' }}
                />
            </div>
        </>
    );
}

export default DoctorCalendar;
