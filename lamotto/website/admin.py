from django.contrib import admin
from .home.models import Client, Manufacture, MotorbikeUse, Cylinder, Receiver
# Register your models here.

admin.site.register(Client)
admin.site.register(Manufacture)
admin.site.register(MotorbikeUse)
admin.site.register(Cylinder)
admin.site.register(Receiver)
