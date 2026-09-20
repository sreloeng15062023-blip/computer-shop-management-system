import api from './axios';

export const repairApi = {
  getAll: (params) => api.get('/repairs', { params }),
  getById: (id) => api.get(`/repairs/${id}`),
  register: (repairData) => api.post('/repairs', repairData),
  updateStatus: (id, statusData) => api.patch(`/repairs/${id}/status`, statusData),
  assignTechnician: (id, technicianId) => api.patch(`/repairs/${id}/assign`, { technician_id: technicianId }),
  addSpareParts: (id, partsData) => api.post(`/repairs/${id}/spare-parts`, partsData),
  getReceipt: (id) => api.get(`/repairs/${id}/receipt`),
};

export default repairApi;
