import {useNavigate} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {Box, Flex, HStack, IconButton, Stack, useColorModeValue, useDisclosure} from "@chakra-ui/react";
import {CloseIcon, HamburgerIcon} from "@chakra-ui/icons";
import {logout} from "../../../config/auth";
import {setGuestRole, setLoggedInFalse, setToken, setUserId} from "../../../state/reducers/authenticationSlice";

const AdminNavbar = () => {
    const navigate = useNavigate();
    const dispatch = useDispatch();
    const {
        token
    } = useSelector((state) => state.authentication);
    const { isOpen, onOpen, onClose } = useDisclosure();

    return (
        <>
            <Box bg={useColorModeValue('gray.100', 'gray.900')} px={4}>
                <Flex h={16} alignItems={'center'} justifyContent={'space-between'}>
                    <IconButton
                        size={'md'}
                        icon={isOpen ? <CloseIcon /> : <HamburgerIcon />}
                        aria-label={'Open Menu'}
                        display={{ md: 'none' }}
                        onClick={isOpen ? onClose : onOpen}
                    />
                    <HStack spacing={8} alignItems={'center'}>
                        <HStack as={'nav'} spacing={4} display={{ base: 'none', md: 'flex' }}>
                            <Box
                                as="a"
                                px={2}
                                py={1}
                                rounded={'md'}
                                _hover={{
                                    textDecoration: 'none',
                                    bg: useColorModeValue('gray.200', 'gray.700'),
                                }}
                                href={'/admin/dashboard'}
                            >
                                Admin panel
                            </Box>
                            <Box
                                as="a"
                                px={2}
                                py={1}
                                rounded={'md'}
                                _hover={{
                                    textDecoration: 'none',
                                    bg: useColorModeValue('gray.200', 'gray.700'),
                                }}
                                href={'/admin/update/users'}
                            >
                                Felhasználók kezelése
                            </Box>
                            <Box
                                as="a"
                                px={2}
                                py={1}
                                rounded={'md'}
                                _hover={{
                                    textDecoration: 'none',
                                    bg: useColorModeValue('gray.200', 'gray.700'),
                                }}
                                href={'/admin/create/users'}
                            >
                                Felhasználó létrehozása
                            </Box>
                            <Box
                                as="a"
                                px={2}
                                py={1}
                                rounded={'md'}
                                _hover={{
                                    textDecoration: 'none',
                                    bg: useColorModeValue('gray.200', 'gray.700'),
                                }}
                                onClick={() => {
                                    logout(token);
                                    dispatch(setToken(''));
                                    dispatch(setGuestRole());
                                    dispatch(setLoggedInFalse());
                                    dispatch(setUserId(''));
                                    navigate('/');
                                }}
                            >
                                Kifejelentkezés
                            </Box>
                        </HStack>
                    </HStack>
                </Flex>

                {isOpen ? (
                    <Box pb={4} display={{ md: 'none' }}>
                        <Stack as={'nav'} spacing={4}>
                            <Box
                                as="a"
                                px={2}
                                py={1}
                                rounded={'md'}
                                _hover={{
                                    textDecoration: 'none',
                                }}
                                href={'/admin/dashboard'}
                            >
                                Admin panel
                            </Box>
                            <Box
                                as="a"
                                px={2}
                                py={1}
                                rounded={'md'}
                                _hover={{
                                    textDecoration: 'none',
                                }}
                                href={'/admin/update/users'}
                            >
                                Felhasználó kezelése
                            </Box>
                            <Box
                                as="a"
                                px={2}
                                py={1}
                                rounded={'md'}
                                _hover={{
                                    textDecoration: 'none',
                                }}
                                href={'/admin/create/users'}
                            >
                                Felhasználó létrehozása
                            </Box>
                            <Box
                                as="a"
                                px={2}
                                py={1}
                                rounded={'md'}
                                _hover={{
                                    textDecoration: 'none',
                                }}
                                onClick={() => {
                                    logout(token);
                                    dispatch(setToken(''));
                                    dispatch(setGuestRole());
                                    dispatch(setLoggedInFalse());
                                    dispatch(setUserId(''));
                                    navigate('/');
                                }}
                                style={{cursor: 'pointer'}}
                            >
                                Kifejelentkezés
                            </Box>
                        </Stack>
                    </Box>
                ) : null}
            </Box>
        </>
    );
}

export default AdminNavbar;
