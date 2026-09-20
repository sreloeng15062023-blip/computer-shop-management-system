import api from './axios';

export const posApi = {
  searchProducts: (query) => api.get('/pos/products/search', { params: { q: query } }),
  applyCoupon: (code, total) => api.post('/pos/coupons/apply', { code, total }),
  createSale: (saleData) => api.post('/pos/sales', saleData),
  getReceipt: (saleId) => api.get(`/pos/sales/${saleId}/receipt`),
};

export default posApi;
