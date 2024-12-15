'use client';
import React, { useEffect, useState } from 'react';
import {
    Container,
    Grid,
    Paper,
    Typography,
    Box,
    Button,
    List,
    ListItem,
    ListItemText,
    Divider
} from '@mui/material';
import api from '@/services/api';
import { useRouter } from 'next/navigation';

interface Order {
    id: number;
    status: string;
    pickup_location: string;
    delivery_location: string;
    created_at: string;
}

export default function ProfilePage() {
    const router = useRouter();
    const [orders, setOrders] = useState<Order[]>([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // التحقق من وجود التوكن
        const token = localStorage.getItem('token');
        if (!token) {
            router.push('/auth/login');
            return;
        }

        const fetchOrders = async () => {
            try {
                const response = await api.get('/orders');
                if (response.data.status && Array.isArray(response.data.data)) {
                    setOrders(response.data.data);
                } else {
                    setOrders([]);
                }
            } catch (error: any) {
                console.error('Error fetching orders:', error);
                // إذا كان هناك خطأ في المصادقة، قم بتوجيه المستخدم إلى صفحة تسجيل الدخول
                if (error.response?.status === 401) {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    router.push('/auth/login');
                }
                setOrders([]);
            } finally {
                setLoading(false);
            }
        };

        fetchOrders();
    }, [router]);

    return (
        <Container maxWidth="lg" sx={{ mt: 4, mb: 4 }}>
            <Grid container spacing={3}>
                {/* Welcome Section */}
                <Grid item xs={12}>
                    <Paper sx={{ p: 2, display: 'flex', flexDirection: 'column' }}>
                        <Typography component="h1" variant="h4" color="primary" gutterBottom>
                            لوحة التحكم
                        </Typography>
                        <Typography variant="subtitle1">
                            مرحباً بك في لوحة التحكم الخاصة بك
                        </Typography>
                    </Paper>
                </Grid>

                {/* Quick Actions */}
                <Grid item xs={12} md={4}>
                    <Paper sx={{ p: 2, display: 'flex', flexDirection: 'column' }}>
                        <Typography component="h2" variant="h6" color="primary" gutterBottom>
                            إجراءات سريعة
                        </Typography>
                        <Button
                            variant="contained"
                            color="primary"
                            sx={{ mb: 1 }}
                            onClick={() => router.push('/dashboard/new-order')}
                        >
                            طلب شاحنة جديدة
                        </Button>
                        <Button
                            variant="outlined"
                            onClick={() => router.push('/dashboard/track-orders')}
                        >
                            تتبع الطلبات
                        </Button>
                    </Paper>
                </Grid>

                {/* Recent Orders */}
                <Grid item xs={12} md={8}>
                    <Paper sx={{ p: 2, display: 'flex', flexDirection: 'column' }}>
                        <Typography component="h2" variant="h6" color="primary" gutterBottom>
                            آخر الطلبات
                        </Typography>
                        <List>
                            {orders.map((order, index) => (
                                <React.Fragment key={order.id}>
                                    <ListItem>
                                        <ListItemText
                                            primary={`طلب رقم: ${order.id}`}
                                            secondary={
                                                <React.Fragment>
                                                    <Typography component="span" variant="body2">
                                                        الحالة: {order.status}
                                                    </Typography>
                                                    <br />
                                                    <Typography component="span" variant="body2">
                                                        من: {order.pickup_location}
                                                    </Typography>
                                                    <br />
                                                    <Typography component="span" variant="body2">
                                                        إلى: {order.delivery_location}
                                                    </Typography>
                                                </React.Fragment>
                                            }
                                        />
                                    </ListItem>
                                    {index < orders.length - 1 && <Divider />}
                                </React.Fragment>
                            ))}
                        </List>
                    </Paper>
                </Grid>
            </Grid>
        </Container>
    );
}
