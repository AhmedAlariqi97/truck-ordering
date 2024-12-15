'use client';
import React from 'react';
import {
    Container,
    Typography,
    Box,
    Button,
    Grid,
    Paper
} from '@mui/material';
import { useRouter } from 'next/navigation';

export default function HomePage() {
    const router = useRouter();

    return (
        <Container maxWidth="lg">
            <Box sx={{ mt: 8, mb: 4 }}>
                <Typography
                    component="h1"
                    variant="h2"
                    align="center"
                    color="text.primary"
                    gutterBottom
                >
                    مرحباً بكم في نظام طلب الشاحنات
                </Typography>
                <Typography variant="h5" align="center" color="text.secondary" paragraph>
                    نظام متكامل لإدارة طلبات الشاحنات وتتبع الشحنات
                </Typography>
                <Box sx={{ mt: 4 }}>
                    <Grid container spacing={2} justifyContent="center">
                        <Grid item>
                            <Button
                                variant="contained"
                                size="large"
                                onClick={() => router.push('/auth/login')}
                            >
                                تسجيل الدخول
                            </Button>
                        </Grid>
                        <Grid item>
                            <Button
                                variant="outlined"
                                size="large"
                                onClick={() => router.push('/register')}
                            >
                                إنشاء حساب جديد
                            </Button>
                        </Grid>
                    </Grid>
                </Box>
            </Box>

            <Grid container spacing={4}>
                <Grid item xs={12} md={4}>
                    <Paper
                        sx={{
                            p: 3,
                            display: 'flex',
                            flexDirection: 'column',
                            height: 240,
                        }}
                    >
                        <Typography variant="h5" component="h2" gutterBottom>
                            طلب شاحنة
                        </Typography>
                        <Typography>
                            قم بطلب شاحنة بكل سهولة وأمان. اختر نوع الشاحنة المناسب لاحتياجاتك
                            وحدد موقع التحميل والتسليم.
                        </Typography>
                    </Paper>
                </Grid>
                <Grid item xs={12} md={4}>
                    <Paper
                        sx={{
                            p: 3,
                            display: 'flex',
                            flexDirection: 'column',
                            height: 240,
                        }}
                    >
                        <Typography variant="h5" component="h2" gutterBottom>
                            تتبع الشحنات
                        </Typography>
                        <Typography>
                            تابع شحنتك في الوقت الفعلي. احصل على تحديثات مباشرة عن موقع
                            شحنتك وموعد وصولها.
                        </Typography>
                    </Paper>
                </Grid>
                <Grid item xs={12} md={4}>
                    <Paper
                        sx={{
                            p: 3,
                            display: 'flex',
                            flexDirection: 'column',
                            height: 240,
                        }}
                    >
                        <Typography variant="h5" component="h2" gutterBottom>
                            إدارة الطلبات
                        </Typography>
                        <Typography>
                            أدر جميع طلباتك من مكان واحد. راجع سجل طلباتك السابقة واحصل
                            على تقارير مفصلة.
                        </Typography>
                    </Paper>
                </Grid>
            </Grid>
        </Container>
    );
}
