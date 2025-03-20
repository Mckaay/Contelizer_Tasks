import axios from "axios";

export const fetchUsers = async (page = 1, searchQuery = '') => {
    try {
        const response = await axios.get("api/users", {
            params: {
                page,
                per_page: 10,
                query: searchQuery
            }
        });
        return response.data.data;
    } catch (error) {
        console.error("Error fetching users:", error.message);
        throw new Error("Failed to fetch users");
    }
};

export const updateUser = async (userId, userData) => {
    try {
        const response = await axios.put(`api/users/${userId}`, userData);

        return {
            success: true,
            data: response.data
        };
    } catch (error) {
        console.error("Error updating user:", error.message);
        return {
            success: false,
            error: error.response?.data?.message[0]?.message || 'Failed to update user'
        };
    }
};

export const deleteUser = async (userId) => {
    try {
        const response = await axios.delete(`api/users/${userId}`);
        return {
            success: true,
            data: response.data
        };
    } catch (error) {
        console.error("Error deleting user:", error.message);
        return {
            success: false,
            error: error.response?.data?.message || 'Failed to delete user'
        };
    }
};