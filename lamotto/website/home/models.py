import sys
from django.db import models
from django.utils import timezone
from datetime import date
from django.core.validators import MinValueValidator, MaxValueValidator
from PIL import Image
from io import BytesIO
from django.core.files.uploadedfile import InMemoryUploadedFile
from django.core.validators import RegexValidator

# Create your models here.
def years_number_min(last):
    return date.today().year - last


def years_number_max(maximo):
    return date.today().year + maximo


class Manufacture(models.Model):
    name = models.CharField(max_length=200)

    def __str__(self):
        return self.name

class MotorbikeUse(models.Model):
    name = models.CharField(max_length=200)

    def __str__(self):
        return self.name

class Receiver(models.Model):
    email = models.EmailField(max_length=70, null=True, blank=True, unique=True)

    def __str__(self):
        return self.email

class Cylinder(models.Model):
    name = models.CharField(max_length=200)

    def __str__(self):
        return self.name

class Client(models.Model):
    phone_regex = RegexValidator(regex=r'^\+?1?\d{9,15}$', message="Phone number must be entered in the format: '+999999999'. Up to 12 digits allowed.")
    phone_number = models.CharField(validators=[phone_regex], max_length=12, blank=True) # validators should be a list
    name = models.CharField(max_length=200)
    last_name = models.CharField(max_length=200)
    motorbike_use = models.ForeignKey(MotorbikeUse, on_delete=models.CASCADE)
    cylinder_head = models.ForeignKey(Cylinder, on_delete=models.CASCADE)
    manufacturer = models.ForeignKey(Manufacture, on_delete=models.CASCADE)
    email = models.EmailField(max_length=70, null=True, blank=True)
    created_date = models.DateTimeField(default=timezone.now)
    model_date = models.IntegerField(default=date.today().year, validators=[MaxValueValidator(years_number_max(1)), MinValueValidator(years_number_min(20))] )

    def publish(self):
        self.created_date = timezone.now()
        self.save()

    def __str__(self):
        return self.name


