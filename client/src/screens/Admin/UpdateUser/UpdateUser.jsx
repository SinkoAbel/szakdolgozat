import React, {useEffect, useState} from 'react';
import {IconButton, Table, TableContainer, Tbody, Td, Th, Thead, Tr} from "@chakra-ui/react";
import axios from "../../../config/axios";
import {DeleteIcon, EditIcon} from "@chakra-ui/icons";
import {ROLE_ADMIN, ROLE_DOCTOR, ROLE_PATIENT} from "../../../config/constants";
import {Link} from "react-router-dom";

const UpdateUser = () => {
    const adminEndpoint = '/api/super/admins';
    const doctorEndpoint = '/api/super/doctors';
    const patientEndpoint = '/api/super/patients';
    const userID = window.sessionStorage.getItem('user_id');

    const [users, setUsers] = useState([]);

    useEffect(() => {
        fetchUsers();
    }, []);

    const fetchUsers = async () => {
        await axios.get('/api/super/users', {
            headers: {
                Authorization: window.sessionStorage.getItem('token')
            }
        }).then(response => {
            setUsers(response.data);
        }).catch(err => {
            console.log(err);
        });
    }

    const deleteUser = async (userRole, userID) => {
        let deleteEndpoint = null;

        switch (userRole) {
            case ROLE_PATIENT:
                deleteEndpoint = patientEndpoint;
                break;
            case ROLE_DOCTOR:
                deleteEndpoint = doctorEndpoint;
                break
            case ROLE_ADMIN:
                deleteEndpoint = adminEndpoint;
                break;
            default:
                console.error('Role is not acceptable.');
                return;
        }

        await axios.delete(deleteEndpoint + `/${userID}`, {
            headers: {
                Authorization: window.sessionStorage.getItem('token')
            }
        }).then(response => {
            fetchUsers();
        }).catch(err => {
            console.log(err);
        });
    }

    return (
        <div className="my-4 mx-5">
            <p className="font-bold underline">
                Felhasználók kezelése:
            </p>

            <TableContainer>
                <Table>
                    <Thead>
                        <Th>Id</Th>
                        <Th>Email</Th>
                        <Th>Szerepkör</Th>
                        <Th>Módosítás</Th>
                        <Th>Törlés</Th>
                    </Thead>
                    <Tbody>
                        {users.map(user => {
                            const currentUser = user.id == userID;

                            return (
                                <Tr key={user.id}>
                                    <Td>{user.id}</Td>
                                    <Td>{user.email}</Td>
                                    <Td>{user.role[0].name}</Td>
                                    <Td>
                                        <IconButton
                                            colorScheme="teal"
                                            aria-label="Módosítás"
                                            icon={ <EditIcon/> }
                                        />
                                    </Td>
                                    { !currentUser &&
                                        <Td>
                                            <Link to={`/admin/update/users/${user.id}`}>
                                                <IconButton
                                                    onClick={() => deleteUser(user.role[0].name, user.id)}
                                                    colorScheme="teal"
                                                    aria-label="Törlés"
                                                    icon={<DeleteIcon/>}
                                                />
                                            </Link>
                                        </Td>
                                    }
                                </Tr>
                            )
                        })}
                    </Tbody>
                </Table>
            </TableContainer>
        </div>
    );
};

export default UpdateUser;