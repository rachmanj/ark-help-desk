import React, { useState } from 'react';
import { usePage, router } from '@inertiajs/react';
import { Table, Tag, Input, Select, Space, Button, Typography, Card, Row, Col } from 'antd';
import { PlusOutlined, SearchOutlined, ReloadOutlined } from '@ant-design/icons';
import AuthenticatedLayout from '@/Pages/Layouts/AuthenticatedLayout';

const { Title } = Typography;

export default function TicketsIndex({ tickets, filters, statuses, priorities, apps }) {
    const [search, setSearch] = useState(filters.search || '');

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

    const priorityColors = { low: 'default', medium: 'blue', high: 'orange', critical: 'red' };
    const priorityLabels = { low: 'Rendah', medium: 'Sedang', high: 'Tinggi', critical: 'Kritis' };

    const handleSearch = () => {
        router.get('/tickets', { ...filters, search, page: 1 }, { preserveState: true, replace: true });
    };

    const handleFilter = (key, value) => {
        router.get('/tickets', { ...filters, [key]: value, page: 1 }, { preserveState: true, replace: true });
    };

    const handleReset = () => {
        setSearch('');
        router.get('/tickets', {}, { preserveState: true, replace: true });
    };

    const columns = [
        {
            title: 'ID',
            dataIndex: 'id',
            width: 80,
            sorter: true,
            render: (id) => <a href={`/tickets/${id}`}>#{id}</a>,
        },
        {
            title: 'Subjek',
            dataIndex: 'subject',
            ellipsis: true,
            render: (text, record) => <a href={`/tickets/${record.id}`}>{text}</a>,
        },
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
            title: 'Prioritas',
            dataIndex: 'priority',
            width: 100,
            render: (p) => <Tag color={priorityColors[p]}>{priorityLabels[p] || p}</Tag>,
        },
        {
            title: 'Pelapor',
            dataIndex: ['user', 'name'],
            width: 150,
        },
        {
            title: 'Dibuat',
            dataIndex: 'created_at',
            width: 170,
            render: (date) => new Date(date).toLocaleString('id-ID'),
        },
    ];

    return (
        <AuthenticatedLayout>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 24 }}>
                <Title level={3} style={{ margin: 0 }}>Tiket</Title>
                <Button type="primary" icon={<PlusOutlined />} href="/tickets/create">
                    Buat Tiket
                </Button>
            </div>

            <Card style={{ marginBottom: 16 }} bodyStyle={{ padding: 16 }}>
                <Row gutter={[12, 12]} align="middle">
                    <Col xs={24} sm={12} md={8}>
                        <Input
                            placeholder="Cari tiket..."
                            prefix={<SearchOutlined />}
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            onPressEnter={handleSearch}
                        />
                    </Col>
                    <Col xs={12} sm={6} md={4}>
                        <Select
                            placeholder="Status"
                            allowClear
                            style={{ width: '100%' }}
                            value={filters.status || undefined}
                            onChange={v => handleFilter('status', v)}
                            options={statuses.map(s => ({ value: s.value, label: s.label }))}
                        />
                    </Col>
                    <Col xs={12} sm={6} md={4}>
                        <Select
                            placeholder="Prioritas"
                            allowClear
                            style={{ width: '100%' }}
                            value={filters.priority || undefined}
                            onChange={v => handleFilter('priority', v)}
                            options={priorities.map(p => ({ value: p.value, label: p.label }))}
                        />
                    </Col>
                    <Col xs={12} sm={6} md={4}>
                        <Select
                            placeholder="Aplikasi"
                            allowClear
                            style={{ width: '100%' }}
                            value={filters.app_id || undefined}
                            onChange={v => handleFilter('app_id', v)}
                            options={apps.map(a => ({ value: a.id, label: a.name }))}
                        />
                    </Col>
                    <Col xs={12} sm={6} md={4}>
                        <Space>
                            <Button onClick={handleSearch} type="primary">Cari</Button>
                            <Button onClick={handleReset} icon={<ReloadOutlined />}>Reset</Button>
                        </Space>
                    </Col>
                </Row>
            </Card>

            <Table
                columns={columns}
                dataSource={tickets.data}
                rowKey="id"
                pagination={{
                    current: tickets.current_page,
                    total: tickets.total,
                    pageSize: tickets.per_page,
                    showSizeChanger: false,
                    onChange: (page) => router.get('/tickets', { ...filters, page }, { preserveState: true, replace: true }),
                }}
                size="middle"
            />
        </AuthenticatedLayout>
    );
}
