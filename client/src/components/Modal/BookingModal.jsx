import React, {useRef, useState} from 'react';
import {
    Button, Modal,
    ModalBody,
    ModalCloseButton,
    ModalContent,
    ModalFooter,
    ModalHeader,
    ModalOverlay, useDisclosure
} from "@chakra-ui/react";
import axios from "../../config/axios";

const BookingModal = (props) => {
    const { isOpen, onOpen, onClose } = useDisclosure();
    const initialRef = useRef(null);
    const finalRef = useRef(null);

    const [success, setSuccess] = useState(false);
    const [fail, setFail] = useState(false);
    const [requestDispatched, setRequestDispatched] = useState(false);

    const handleAppointmentBooking = async () => {
        setRequestDispatched(true);
        setSuccess(false);
        setFail(false);

        const bookingEndpoint = '/api/bookings';

        await axios.post(bookingEndpoint, {
            bookable_reception_times_id: props.receptionTimeID,
            patient_user_id: props.userID
        }, {
            headers: {
                Authorization: window.sessionStorage.getItem('token')
            }
        }).then(response => {
            setSuccess(true);
        }).catch(err => {
            console.log(err);
            setFail(true);
        });

        setTimeout(async () => {
            await props.fetchAppointments(props.doctorID);
            onClose();
        }, 2000)
    }

    return (
        <>
            <Button colorScheme="teal" onClick={onOpen}>
                Foglalás
            </Button>

            <Modal
                initialFocusRef={initialRef}
                finalFocusRef={finalRef}
                isOpen={isOpen}
                onClose={onClose}
            >
                <ModalOverlay />
                <ModalContent>
                    <ModalCloseButton />
                    <ModalHeader>Figyelem!</ModalHeader>
                    <ModalBody pb={6}>
                        <p className="font-bold">Biztosan le szeretné ezt az időpontot foglalni?</p>
                        { fail &&
                            <p className="bg-red-300 py-2 px-2 font-bold rounded-lg text-center mt-3">
                                Mentés sikertelen!
                            </p>
                        }
                        { success &&
                            <p className="bg-green-200 py-2 px-2 font-bold rounded-lg text-center mt-3">
                                Sikeres mentés!
                            </p>
                        }
                    </ModalBody>

                    <ModalFooter>
                        { !requestDispatched &&
                            <>
                                <Button colorScheme='teal' mr={3} onClick={() => handleAppointmentBooking()}>
                                    Igen
                                </Button>
                                <Button onClick={onClose}>Nem</Button>
                            </>
                        }
                    </ModalFooter>
                </ModalContent>
            </Modal>
        </>
    );
};

export default BookingModal;