import React, {useEffect, useState} from 'react';
import {IconButton, Select, Table, TableContainer, Tbody, Td, Th, Thead, Tr} from "@chakra-ui/react";
import axios from "../../../config/axios";
import {DeleteIcon, EditIcon} from "@chakra-ui/icons";
import {getRoleAlias, ROLE_ADMIN, ROLE_DOCTOR, ROLE_PATIENT} from "../../../config/constants";
import {Link} from "react-router-dom";
import { useSelector } from 'react-redux';

const UpdateUser = () => {
    const everyUserFilterValue = 'everyUser';

    const adminEndpoint = '/api/super/admins';
    const doctorEndpoint = '/api/super/doctors';
    const patientEndpoint = '/api/super/patients';

    const {
        userId,
        token
    } = useSelector((state) => state.authentication);

    const [users, setUsers] = useState([]);

    useEffect(() => {
        fetchUsers();
    }, []);

    const fetchUsers = async () => {
        await axios.get('/api/super/users', {
            headers: {
                Authorization: token
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
                Authorization: token
            }
        }).then(response => {
            fetchUsers();
        }).catch(err => {
            console.log(err);
        });
    }

    const handleUserRoleFilter = async (roleFilter) => {
        let filterEndpoint;

        filterEndpoint = roleFilter === everyUserFilterValue ?
            '/api/super/users'
            :
            `/api/super/users?filters[role]=${roleFilter}`;

        await axios.get(filterEndpoint, {
            headers: {
                Authorization: token
            }
        }).then(response => {
            setUsers(response.data);
        }).catch(err => {
            console.error(err);
        });
    }

    return (
        <div className="my-4 mx-5">
            <p className="font-bold underline">
                Felhasználók kezelése:
            </p>

            <div className="my-3">
                <p>Szűrés szerepkörre:</p>
                <Select id="roleFilter"
                    onChange={(e) => {
                        handleUserRoleFilter(e.target.value);
                    }}
                >
                    <option selected disabled>Válasszon szerepkört!</option>
                    <option value={everyUserFilterValue}>Minden felhasználó</option>
                    <option value={ROLE_PATIENT}>{getRoleAlias(ROLE_PATIENT)}</option>
                    <option value={ROLE_DOCTOR}>{getRoleAlias(ROLE_DOCTOR)}</option>
                    <option value={ROLE_ADMIN}>{getRoleAlias(ROLE_ADMIN)}</option>
                </Select>
            </div>

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
                            const currentUser = user.id == userId;

                            return (
                                <Tr key={user.id}>
                                    <Td>{user.id}</Td>
                                    <Td>{user.email}</Td>
                                    <Td>{user.role[0].name}</Td>
                                    {!currentUser &&
                                        <>
                                            <Td>
                                                <Link to={`/admin/update/users/${user.id}`}>
                                                    <IconButton
                                                        colorScheme="teal"
                                                        aria-label="Módosítás"
                                                        icon={ <EditIcon/> }
                                                    />
                                                </Link>
                                            </Td>
                                            <Td>
                                                <IconButton
                                                    onClick={() => deleteUser(user.role[0].name, user.id)}
                                                    colorScheme="teal"
                                                    aria-label="Törlés"
                                                    icon={<DeleteIcon/>}
                                                />
                                            </Td>
                                        </>
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