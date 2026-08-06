import React from 'react';
import { usePage } from '@inertiajs/react';
import { Row, Col, Card, Statistic, Table, Tag, Typography } from 'antd';
import {
    InboxOutlined,
    ExclamationCircleOutlined,
    CheckCircleOutlined,
    ClockCircleOutlined,
    RobotOutlined,
    DollarOutlined,
} from '@ant-design/icons';
import AuthenticatedLayout from '@/Pages/Layouts/AuthenticatedLayout';

const { Title } = Typography;

export default function DashboardIndex({ stats, recentTickets }) {
    const statusColors = {
        open: 'blue',
        ai_replied: 'cyan',
        escalated: 'orange',
        in_progress: 'processing',
        resolved: 'green',
        closed: 'default',
    };

    const statusLabels = {
        open: 'Terbuka',
        ai_replied: 'Dibalas AI',
        escalated: 'Dieskalasi',
        in_progress: 'Dalam Proses',
        resolved: 'Terselesaikan',
        closed: 'Ditutup',
    };

    const columns = [
        {
            title: 'ID',
            dataIndex: 'id',
            width: 60,
            render: (id) => <a href={`/tickets/${id}`}>#{id}</a>,
        },
        { title: 'Subjek', dataIndex: 'subject', ellipsis: true },
        {
            title: 'Aplikasi',
            dataIndex: ['app', 'name'],
            width: 150,
        },
        {
            title: 'Status',
            dataIndex: 'status',
            width: 130,
            render: (s) => <Tag color={statusColors[s]}>{statusLabels[s] || s}</Tag>,
        },
        {
            title: 'Pelapor',
            dataIndex: ['user', 'name'],
            width: 150,
        },
    ];

    return (
        <AuthenticatedLayout>
            <Title level={3} style={{ marginBottom: 24 }}>Dasbor</Title>

            <Row gutter={[16, 16]} style={{ marginBottom: 32 }}>
                <Col xs={24} sm={12} lg={6}>
                    <Card>
                        <Statistic
                            title="Tiket Terbuka"
                            value={stats.open}
                            prefix={<InboxOutlined />}
                            valueStyle={{ color: '#1677ff' }}
                        />
                    </Card>
                </Col>
                <Col xs={24} sm={12} lg={6}>
                    <Card>
                        <Statistic
                            title="Dieskalasi"
                            value={stats.escalated}
                            prefix={<ExclamationCircleOutlined />}
                            valueStyle={{ color: '#fa8c16' }}
                        />
                    </Card>
                </Col>
                <Col xs={24} sm={12} lg={6}>
                    <Card>
                        <Statistic
                            title="Dalam Proses"
                            value={stats.in_progress}
                            prefix={<ClockCircleOutlined />}
                            valueStyle={{ color: '#1677ff' }}
                        />
                    </Card>
                </Col>
                <Col xs={24} sm={12} lg={6}>
                    <Card>
                        <Statistic
                            title="Selesai Hari Ini"
                            value={stats.resolved_today}
                            prefix={<CheckCircleOutlined />}
                            valueStyle={{ color: '#52c41a' }}
                        />
                    </Card>
                </Col>
            </Row>

            {/* AI Stats Row */}
            <Row gutter={[16, 16]} style={{ marginBottom: 32 }}>
                <Col xs={24} sm={12} lg={6}>
                    <Card>
                        <Statistic
                            title="Tiket Diselesaikan AI"
                            value={stats.ai_solve_rate}
                            suffix="%"
                            precision={1}
                            prefix={<RobotOutlined />}
                            valueStyle={{ color: '#722ed1' }}
                        />
                    </Card>
                </Col>
                <Col xs={24} sm={12} lg={6}>
                    <Card>
                        <Statistic
                            title="Biaya AI Bulan Ini"
                            value={stats.ai_cost_this_month}
                            precision={4}
                            prefix={<DollarOutlined />}
                            suffix="USD"
                            valueStyle={{ color: '#13c2c2' }}
                        />
                    </Card>
                </Col>
            </Row>

            <Title level={4} style={{ marginBottom: 16 }}>Tiket Terbaru</Title>
            <Table
                columns={columns}
                dataSource={recentTickets}
                rowKey="id"
                pagination={false}
                size="middle"
            />
        </AuthenticatedLayout>
    );
}
