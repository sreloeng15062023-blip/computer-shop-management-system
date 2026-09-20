import api from './axios';

export const authApi = {
  login: (credentials) => api.post('/auth/login', credentials),
  logout: () => api.post('/auth/logout'),
  getProfile: () => api.get('/auth/user'),
  changePassword: (data) => api.post('/auth/change-password', data),
};

export default authApi;
